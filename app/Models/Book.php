<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Factories\HasFactory;
   use Illuminate\Database\Eloquent\Model;

   class Book extends Model
   {
       use HasFactory;

       protected $fillable = [
           'title',
           'author',
           'publisher_id',
           'cover_image',
           'genre_id',
           'quantity',
       ];

       public function genre()
       {
           return $this->belongsTo(Genre::class);
       }

       public function publisher()
       {
           return $this->belongsTo(Publisher::class);
       }

       public function borrowedBooks()
       {
           return $this->hasMany(BorrowedBook::class);
       }
   }