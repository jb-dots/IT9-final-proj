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
        $this->middleware('admin'); // Apply the admin middleware to all methods
    }

    public function index()
    {
        $lateFeePerDay = 0.50; // $0.50 per day late

        // Fetch all books
        $books = Book::with('genre')->get();

        // Fetch all genres
        $genres = \App\Models\Genre::orderBy('name')->get();

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
                'publisher' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $coverImagePath = $request->file('cover_image')->store('images', 'public');

            Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'description' => $request->description,
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

// app/Http/Controllers/AdminController.php
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
        $stockIns = \App\Models\StockIn::where('book_id', $book->id)
            ->with('supplier')
            ->orderBy('created_at', 'desc')
            ->get();

        $stockOuts = \App\Models\StockOut::where('book_id', $book->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $suppliers = \App\Models\Supplier::orderBy('name')->get();

        return view('admin.adjust-stock', compact('book', 'stockIns', 'stockOuts', 'suppliers'));
    }

    public function stockIn(Request $request, Book $book)
    {
        try {
            $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $quantity = $request->input('quantity');
            $supplierId = $request->input('supplier_id');

            $book->quantity += $quantity;
            $book->save();

            $userName = auth()->user() ? auth()->user()->name : 'Unknown';

            \App\Models\StockIn::create([
                'book_id' => $book->id,
                'supplier_id' => $supplierId,
                'quantity' => $quantity,
                'performed_by' => $userName,
            ]);

            return redirect()->route('admin.adjustStock', $book)->with('success', 'Stock in recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to record stock in: ' . $e->getMessage());
        }
    }

    public function stockOut(Request $request, Book $book)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $quantity = $request->input('quantity');

            if ($quantity > $book->quantity) {
                return redirect()->back()->with('error', 'Cannot stock out more books than available.');
            }

            $book->quantity -= $quantity;
            $book->save();

            $userName = auth()->user() ? auth()->user()->name : 'Unknown';

            \App\Models\StockOut::create([
                'book_id' => $book->id,
                'quantity' => $quantity,
                'performed_by' => $userName,
            ]);

            return redirect()->route('admin.adjustStock', $book)->with('success', 'Stock out recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to record stock out: ' . $e->getMessage());
        }
    }

    /**
     * Show the form to create a new supplier.
     */
    public function createSupplier()
    {
        return view('admin.add-supplier');
    }

    /**
     * Store a new supplier in the database.
     */
    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:suppliers,name|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
        ]);

        \App\Models\Supplier::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return redirect()->route('admin.suppliers.create')->with('success', 'Supplier added successfully.');
    }
}
