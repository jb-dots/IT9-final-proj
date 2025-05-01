<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BorrowedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'status',
        'borrowed_at',
        'due_date',
        'returned_at',
        'late_fee',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
        'late_fee' => 'decimal:2',
    ];

    /**
     * Calculate the late fee for the borrowed book.
     *
     * @return float
     */
    public function calculateLateFee()
    {
        // If the book is returned or not yet due, no late fee applies
        if ($this->returned_at || $this->due_date >= now()) {
            return 0.00;
        }

        // Calculate days overdue (starting from the day after due_date)
        $daysLate = $this->due_date->startOfDay()->diffInDays(now()->startOfDay());

        // Charge $1.00 per day overdue
        $dailyFee = 1.00;
        $lateFee = $daysLate * $dailyFee;

        return round($lateFee, 2);
    }

    /**
     * Relationship to the Book model
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relationship to the User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}