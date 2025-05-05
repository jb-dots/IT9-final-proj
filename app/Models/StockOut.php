<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'quantity',
        'performed_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
