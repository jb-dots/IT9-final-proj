<?php

namespace App\Http\Controllers;

use App\Models\Book; // Assuming you have a Book model
use Illuminate\Http\Request;

abstract class Controller
{
    //
}

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::all(); // Or however you want to fetch your books
        return view('dashboard', ['books' => $books]);
    }
}
