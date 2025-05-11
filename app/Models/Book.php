<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'cover_image', 'quantity', 'publisher', 'description', 'special_book_id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($book) {
            if (!$book->special_book_id) {
                $book->special_book_id = 'GAB-' . str_pad($book->id, 5, '0', STR_PAD_LEFT);
                $book->save();
            }
        });
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
