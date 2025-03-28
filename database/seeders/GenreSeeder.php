<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Fantasy', 'Sci-fi', 'Romance', 'Thriller', 'Comedy', 'Crime Fiction',
            'Western Fiction', 'Biography', 'Non-Fiction', 'Historical Fiction', 'Mystery', 'Horror',
            'Adventure', 'Young Adult', 'Self-Help', 'Classics', 'Contemporary Fiction', 'Dystopian',
            'Erotica', 'Graphic Novels', 'Literary Fiction', 'Magical Realism', 'Paranormal', 'Poetry',
            'Psychological Thriller', 'Satire', 'Science', 'Spirituality', 'Sports', 'Travel',
            'True Crime', 'Urban Fantasy', "Women's Fiction", "Children's Literature", 'Middle Grade', 'Cookbooks',
            'Business', 'Technology', 'Health & Wellness', 'Philosophy', 'Political Fiction', 'Short Stories',
            'Essays', 'Memoirs', 'Autobiographies'
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}