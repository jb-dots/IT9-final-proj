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

    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        $books = $genre->books;
        return view('genre.show', compact('genre', 'books'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.books.create', compact('genres')); // Updated view path for clarity
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre_id' => 'required|exists:genres,id', // Added genre validation
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable for updates
            'genre_id' => 'required|exists:genres,id',
            'is_borrowed' => 'boolean',
        ]);

        $book->title = $request->title;
        $book->author = $request->author;
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

    // Admin-specific index for the books table
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
            'due_date' => now()->addDays(14), // Set due date to 14 days from now
        ]);

        return redirect()->back()->with('success', 'Book borrowed successfully. Due date: ' . now()->addDays(14)->format('Y-m-d'));
    }
}