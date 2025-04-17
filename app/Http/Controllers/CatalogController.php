<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['borrow', 'storeBorrow']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $genres = Genre::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(18);

        return view('catalogs', compact('genres'));
    }

    public function show(Request $request, Genre $genre)
    {
        $search = $request->input('search');

        $books = $genre->books()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('genre.show', compact('genre', 'books'));
    }

    public function borrow($id)
    {
        // Fetch the book details using the provided ID
        $book = Book::find($id);

        // Check if the book exists
        if (!$book) {
            return redirect()->route('catalogs')->with('error', 'Book not found.');
        }

        // Return the view for borrowing the book, passing the book details
        return view('catalogs.book-borrow', compact('book'));
    }

    public function storeBorrow(Request $request, $id)
    {
        try {
            $request->validate([
                'borrow_days' => 'required|integer|min:1|max:30',
            ]);

            $book = Book::findOrFail($id);

            // Check if the book is available (quantity > 0)
            if ($book->quantity <= 0) {
                return redirect()->back()->with('error', 'This book is currently out of stock.');
            }

            // Check if the user has already borrowed this book and not returned it
            $existingBorrow = BorrowedBook::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->first();

            if ($existingBorrow) {
                return redirect()->back()->with('error', 'You have already borrowed this book and not yet returned it.');
            }

            // Calculate due date
            $borrowDays = $request->borrow_days;
            $dueDate = Carbon::now()->addDays($borrowDays);

            // Create a new borrowed book record
            BorrowedBook::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'borrowed_at' => Carbon::now(),
                'due_date' => $dueDate,
                'status' => 'borrowed',
                'late_fee' => 0,
            ]);

            // Decrease the book's quantity
            $book->quantity -= 1;
            $book->save();

            return redirect()->route('genre.show', $book->genre_id)->with('success', 'Book borrowed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to borrow book: ' . $e->getMessage());
        }
    }
}