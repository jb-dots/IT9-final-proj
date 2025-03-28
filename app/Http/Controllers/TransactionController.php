<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch books that are due (not returned yet and past due date)
        $dueBooks = Borrowing::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->with('book')
            ->get();

        // Fetch recently returned books
        $returnedBooks = Borrowing::where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->with('book')
            ->orderBy('returned_at', 'desc')
            ->take(5) // Limit to 5 recent returns
            ->get();

        // Calculate due amount (e.g., based on late fees)
        $dueAmount = $dueBooks->sum(function ($borrowing) {
            $daysLate = now()->diffInDays($borrowing->due_date);
            return $daysLate > 0 ? $daysLate * 0.50 : 0; // Example: $0.50 per day late
        });

        return view('transactions', compact('dueBooks', 'returnedBooks', 'dueAmount'));
    }
}