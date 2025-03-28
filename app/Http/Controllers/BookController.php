<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('dashboard', compact('books'));
    }


    public function favorites()
    {
        $favorites = Book::where('is_favorite', true)->get();
        return view('favorites', compact('favorites'));
    }
}
