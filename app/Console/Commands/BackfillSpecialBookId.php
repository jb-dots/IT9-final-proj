<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Str;

class BackfillSpecialBookId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:backfill-special-book-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill special_book_id for existing books';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $books = Book::whereNull('special_book_id')->get();

        if ($books->isEmpty()) {
            $this->info('All books already have special_book_id.');
            return 0;
        }

        foreach ($books as $book) {
            // Generate a unique special_book_id in format "GAB-00003"
            $book->special_book_id = 'GAB-' . str_pad($book->id, 5, '0', STR_PAD_LEFT);
            $book->save();

            $this->info("Backfilled special_book_id for book ID {$book->id}");
        }

        $this->info('Backfilling special_book_id completed.');

        return 0;
    }
}
