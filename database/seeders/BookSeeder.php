<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $crimeFiction = Genre::where('name', 'Crime Fiction')->first();
        $fineArts = Genre::where('name', 'Fine Arts')->first();

        if ($crimeFiction) {
            $books = [
                [
                    'title' => 'The Great Adventures of Sherlock Holmes',
                    'author' => 'Arthur Conan Doyle',
                    'cover_image' => 'images/the-great-adventures-of-sherlock-holmes-1-10.png',
                    'genre_id' => $crimeFiction->id,
                ],
                [
                    'title' => 'The Adventures of Arsene Lupin, Gentleman-Thief',
                    'author' => 'Maurice Leblanc',
                    'cover_image' => 'images/the-adventures-of-arsene-lupin-gentleman-thief-10.png',
                    'genre_id' => $crimeFiction->id,
                ],
            ];

            foreach ($books as $book) {
                Book::create($book);
            }
        }

        if ($fineArts) {
            $books = [
                [
                    'title' => 'The Art of the Renaissance',
                    'author' => 'Peter Murray',
                    'cover_image' => 'images/art-of-the-renaissance.png',
                    'genre_id' => $fineArts->id,
                ],
                [
                    'title' => 'Modern Art: A History',
                    'author' => 'Hans Richter',
                    'cover_image' => 'images/modern-art-history.png',
                    'genre_id' => $fineArts->id,
                ],
            ];

            foreach ($books as $book) {
                Book::create($book);
            }
        }
    }
}