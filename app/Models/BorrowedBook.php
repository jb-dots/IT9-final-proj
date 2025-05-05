<?php
// app/Models/BorrowedBook.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BorrowedBook extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'late_fee',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate the late fee for this borrowed book.
     *
     * @return float
     */
    public function calculateLateFee()
    {
        $lateFeePerDay = 0.50; // $0.50 per day late

        if (!$this->returned_at && $this->due_date < now()) {
            $daysLate = now()->diffInDays($this->due_date);
            return $daysLate * $lateFeePerDay;
        }

        return 0.00;
    }
}