<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct()
    {
        // Apply admin middleware only to specific methods
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'toggleStatus']);
    }

    public function index()
    {
        $books = Book::all();
        return view('dashboard', compact('books'));
    }

    // Updated show method to display a single book's description
    public function show($id)
    {
        $book = Book::with('ratings')->findOrFail($id);
        $averageRating = $book->ratings()->avg('rating');
        return view('books.description', compact('book', 'averageRating')); // Points to description.blade.php
    }

    // New method to handle genre display (replacing old show logic)
    public function showGenre($id)
    {
        $genre = Genre::findOrFail($id);
        $books = $genre->books()->with('ratings')->when(request('search'), function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
        })->get();

        // Add average_rating and rating_count attribute to each book
        $books->map(function ($book) {
            $book->average_rating = $book->ratings->avg('rating') ?? 0;
            $book->rating_count = $book->ratings->count();
            return $book;
        });

        return view('genre.show', compact('genre', 'books'));
    }

    public function rateBook(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $book = Book::findOrFail($id);
        $user = $request->user();

        // Update or create rating for this user and book
        $rating = $book->ratings()->updateOrCreate(
            ['user_id' => $user->id],
            ['rating' => $request->rating]
        );

        return redirect()->route('books.show', $book->id)->with('success', 'Your rating has been submitted.');
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.books.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->description = $request->description;
        $book->genre_id = $request->genre_id;

        if ($request->hasFile('cover_image')) {
            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        $genres = Genre::all();
        return view('admin.books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'is_borrowed' => 'boolean',
        ]);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->description = $request->description;
        $book->genre_id = $request->genre_id;
        $book->is_borrowed = $request->boolean('is_borrowed', $book->is_borrowed);

        if ($request->hasFile('cover_image')) {
            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function toggleStatus(Book $book)
    {
        $book->is_borrowed = !$book->is_borrowed;
        $book->save();
        return redirect()->route('admin.books.index')->with('success', 'Book status updated.');
    }

    public function favorites()
    {
        $favorites = Book::where('is_favorite', true)->get();
        return view('favorites', compact('favorites'));
    }

    public function adminIndex()
    {
        $books = Book::with('genre')->get();
        return view('admin.books.index', compact('books'));
    }

    public function borrow(Request $request, Book $book)
    {
        // Check if the book is already borrowed by the user and not returned
        $existingBorrow = BorrowedBook::where('book_id', $book->id)
            ->where('user_id', Auth::id())
            ->where('status', 'borrowed')
            ->whereNull('returned_at')
            ->first();

        if ($existingBorrow) {
            return redirect()->back()->with('error', 'You have already borrowed this book.');
        }

        // Create a new borrowing record
        BorrowedBook::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'status' => 'borrowed',
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
        ]);

        return redirect()->back()->with('success', 'Book borrowed successfully. Due date: ' . now()->addDays(14)->format('Y-m-d'));
    }
}
