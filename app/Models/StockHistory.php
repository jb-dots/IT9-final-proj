<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'quantity_change',
        'action',
        'performed_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}