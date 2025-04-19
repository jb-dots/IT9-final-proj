<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\BorrowedBook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware handled by routes
    }

    public function index()
    {
        $lateFeePerDay = 0.50;

        // Clear any query cache to ensure fresh data
        \Illuminate\Support\Facades\Cache::flush();

        $books = Book::with('genre')->get();
        \Log::info('Books fetched for dashboard', $books->toArray());

        $genres = Genre::orderBy('name')->get();
        $borrowedBooks = BorrowedBook::with(['book', 'user'])
            ->orderBy('borrowed_at', 'desc')
            ->get();

        foreach ($borrowedBooks as $borrowedBook) {
            if (!$borrowedBook->returned_at && $borrowedBook->due_date < now()) {
                $daysLate = now()->diffInDays($borrowedBook->due_date);
                $lateFee = $daysLate * $lateFeePerDay;
                $borrowedBook->update(['late_fee' => $lateFee]);
            } elseif (!$borrowedBook->returned_at && $borrowedBook->due_date >= now()) {
                $borrowedBook->update(['late_fee' => 0]);
            }
        }

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
            \Log::info('Raw request data', $request->all());

            DB::beginTransaction();

            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'publisher' => 'nullable|string|max:255',
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $coverImagePath = $request->file('cover_image')->store('images', 'public');

            $data = [
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'cover_image' => $coverImagePath,
                'genre_id' => $request->genre_id,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            \Log::info('Attempting to create book', $data);

            $bookId = DB::table('books')->insertGetId($data);

            \Log::info('Book created successfully', ['book_id' => $bookId]);

            $book = Book::find($bookId);

            DB::commit();

            return redirect()->route('admin.index')->with('success', 'Book added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add book: ' . $e->getMessage(), ['exception' => $e]);
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
            \Log::info('Raw request data for update', $request->all());

            DB::beginTransaction();

            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'publisher' => 'nullable|string|max:255',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $data = [
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'genre_id' => $request->genre_id,
            ];

            if ($request->hasFile('cover_image')) {
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')->store('images', 'public');
            }

            \Log::info('Book state before update', [
                'book_id' => $book->id,
                'current_data' => $book->toArray(),
            ]);

            \Log::info('Attempting to update book', [
                'book_id' => $book->id,
                'data' => $data,
            ]);

            $result = DB::table('books')
                ->where('id', $book->id)
                ->update($data);

            \Log::info('Update result', [
                'book_id' => $book->id,
                'result' => $result,
            ]);

            $book->refresh();

            \Log::info('Book state after update', [
                'book_id' => $book->id,
                'updated_data' => $book->toArray(),
            ]);

            DB::commit();

            return redirect()->route('admin.index')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update book: ' . $e->getMessage(), ['exception' => $e]);
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
            if ($borrowedBook->late_fee <= 0) {
                return redirect()->route('admin.index')->with('error', 'No late fee to pay for this book.');
            }

            Transaction::create([
                'user_id' => $borrowedBook->user_id,
                'amount' => $borrowedBook->late_fee,
                'type' => 'payment',
                'description' => 'Payment for late fee on book: ' . $borrowedBook->book->title,
            ]);

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