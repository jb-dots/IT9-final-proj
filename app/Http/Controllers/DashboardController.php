<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the user's borrowed books
        $borrowedBooks = BorrowedBook::where('user_id', Auth::id())
            ->with('book')
            ->get();

        // Count overdue books
        $overdueCount = BorrowedBook::where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->count();

        // Fetch trending books (latest 5 books)
        $books = Book::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Fetch top books (most borrowed)
        $topBooks = Book::select('books.*')
            ->leftJoinSub(
                BorrowedBook::select('book_id')
                    ->groupBy('book_id')
                    ->selectRaw('book_id, COUNT(*) as borrow_count'),
                'borrow_counts',
                'books.id',
                '=',
                'borrow_counts.book_id'
            )
            ->orderByRaw('borrow_counts.borrow_count DESC NULLS LAST')
            ->take(5)
            ->get();

        // Fetch most read books (most returned)
        $mostReadBooks = Book::select('books.*')
            ->leftJoinSub(
                BorrowedBook::select('book_id')
                    ->where('status', 'returned')
                    ->groupBy('book_id')
                    ->selectRaw('book_id, COUNT(*) as return_count'),
                'return_counts',
                'books.id',
                '=',
                'return_counts.book_id'
            )
            ->orderByRaw('return_counts.return_count DESC NULLS LAST')
            ->take(5)
            ->get();

        return view('dashboard', compact('borrowedBooks', 'overdueCount', 'books', 'topBooks', 'mostReadBooks'));
    }
}