<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BorrowedBook;

class UpdateLateFees extends Command
{
    protected $signature = 'fees:update';
    protected $description = 'Update late fees for overdue borrowed books';

    public function handle()
    {
        $borrowedBooks = BorrowedBook::whereNull('returned_at')->get();

        foreach ($borrowedBooks as $borrowedBook) {
            $borrowedBook->late_fee = $borrowedBook->calculateLateFee();
            $borrowedBook->save();
        }

        $this->info('Late fees updated successfully.');
    }
}