<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'cover_image', 'genre_id', 'quantity', 'publisher', 'description'];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
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