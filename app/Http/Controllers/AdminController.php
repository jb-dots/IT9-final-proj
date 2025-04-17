<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\BorrowedBook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Removed 'admin' middleware; handled by route middleware 'role:admin'
    }

    public function index()
    {
        $lateFeePerDay = 0.50; // $0.50 per day late

        // Fetch all books
        $books = Book::with('genre')->get();

        // Fetch all genres
        $genres = Genre::orderBy('name')->get();

        // Fetch borrowed books with user information
        $borrowedBooks = BorrowedBook::with(['book', 'user'])
            ->orderBy('borrowed_at', 'desc')
            ->get();

        // Calculate and update late fees for overdue books
        foreach ($borrowedBooks as $borrowedBook) {
            if (!$borrowedBook->returned_at && $borrowedBook->due_date < now()) {
                $daysLate = now()->diffInDays($borrowedBook->due_date);
                $lateFee = $daysLate * $lateFeePerDay;
                $borrowedBook->update(['late_fee' => $lateFee]);
            } elseif (!$borrowedBook->returned_at && $borrowedBook->due_date >= now()) {
                $borrowedBook->update(['late_fee' => 0]);
            }
        }

        // Refresh the borrowed books collection
        $borrowedBooks = BorrowedBook::with(['book', 'user'])
            ->orderBy('borrowed_at', 'desc')
            ->get();

        return view('admin.index', compact('books', 'borrowedBooks', 'genres'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.create', compact('genres'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $coverImagePath = $request->file('cover_image')->store('images', 'public');

            Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'cover_image' => $coverImagePath,
                'genre_id' => $request->genre_id,
            ]);

            return redirect()->route('admin.index')->with('success', 'Book added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add book: ' . $e->getMessage());
        }
    }

    public function edit(Book $book)
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $data = [
                'title' => $request->title,
                'author' => $request->author,
                'genre_id' => $request->genre_id,
            ];

            if ($request->hasFile('cover_image')) {
                // Delete the old image
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')->store('images', 'public');
            }

            $book->update($data);

            return redirect()->route('admin.index')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }

    public function updateBorrowStatus(Request $request, BorrowedBook $borrowedBook)
    {
        try {
            $request->validate([
                'status' => 'required|in:borrowed,returned',
            ]);

            if ($request->status === 'returned' && $borrowedBook->status === 'borrowed') {
                // Increase the book's quantity when returned
                $book = $borrowedBook->book;
                $book->quantity += 1;
                $book->save();
            }

            $borrowedBook->update([
                'status' => $request->status,
                'returned_at' => $request->status === 'returned' ? now() : null,
            ]);

            return redirect()->route('admin.index')->with('success', 'Borrow status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update borrow status: ' . $e->getMessage());
        }
    }

    public function markAsPaid(Request $request, BorrowedBook $borrowedBook)
    {
        try {
            // Ensure the book has a late fee
            if ($borrowedBook->late_fee <= 0) {
                return redirect()->route('admin.index')->with('error', 'No late fee to pay for this book.');
            }

            // Record the payment in the transactions table
            Transaction::create([
                'user_id' => $borrowedBook->user_id,
                'amount' => $borrowedBook->late_fee,
                'type' => 'payment',
                'description' => 'Payment for late fee on book: ' . $borrowedBook->book->title,
            ]);

            // Clear the late fee
            $borrowedBook->update(['late_fee' => 0]);

            return redirect()->route('admin.index')->with('success', 'Late fee marked as paid.');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', 'Failed to mark late fee as paid: ' . $e->getMessage());
        }
    }

    public function adjustStock(Book $book)
    {
        return view('admin.adjust-stock', compact('book'));
    }

    public function updateStock(Request $request, Book $book)
    {
        try {
            $request->validate([
                'quantity_change' => 'required|integer',
                'action' => 'required|in:stock_in,stock_out',
            ]);

            $quantityChange = $request->quantity_change;
            $action = $request->action;

            if ($action === 'stock_in') {
                $book->quantity += $quantityChange;
            } elseif ($action === 'stock_out') {
                $newQuantity = $book->quantity - $quantityChange;
                if ($newQuantity < 0) {
                    return redirect()->back()->with('error', 'Cannot stock out more books than available.');
                }
                $book->quantity = $newQuantity;
            }

            $book->save();

            return redirect()->route('admin.index')->with('success', 'Book stock updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update stock: ' . $e->getMessage());
        }
    }
}