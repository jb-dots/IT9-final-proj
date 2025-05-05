<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'supplier_id',
        'quantity',
        'performed_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
