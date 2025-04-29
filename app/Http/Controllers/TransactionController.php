<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all borrowed books for the user
        $borrowedBooks = BorrowedBook::where('user_id', $user->id)
            ->with('book')
            ->orderBy('borrowed_at', 'desc')
            ->get();

        // Calculate late fees dynamically for each borrowed book
        foreach ($borrowedBooks as $borrowedBook) {
            $borrowedBook->late_fee = $borrowedBook->calculateLateFee();
            $borrowedBook->save();
        }

        // Fetch books that are due (not returned yet and past due date)
        $dueBooks = BorrowedBook::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->with('book')
            ->get();

        // Fetch recently returned books
        $returnedBooks = BorrowedBook::where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->with('book')
            ->orderBy('returned_at', 'desc')
            ->take(5)
            ->get();

        // Calculate total due amount from late fees
        $dueAmount = $borrowedBooks->whereNull('returned_at')->sum('late_fee');

        // Fetch payment history
        $paymentHistory = Transaction::where('user_id', $user->id)
            ->where('type', 'payment')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('transactions', compact('borrowedBooks', 'dueBooks', 'returnedBooks', 'dueAmount', 'paymentHistory'));
    }
    public function availableBooks()
    {
        $books = Book::where('is_available', true)->get();
        return view('books.available', compact('books'));
    }
    public function borrow(Request $request, Book $book)
    {
        // Check if the book is available
        if (!$book->is_available) {
            return redirect()->back()->with('error', 'This book is already borrowed.');
        }
    
        // Create a borrowed book record
        $dueDate = now()->addDays(14); // Due in 14 days
        BorrowedBook::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => $dueDate,
            'status' => 'borrowed',
            'late_fee' => 0.00,
        ]);
    
        // Mark the book as unavailable
        $book->update(['is_available' => false]);
    
        return redirect()->route('transactions')->with('success', 'Book borrowed successfully!');
    }
}