<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Book;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $genres = Genre::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(18);

        return view('catalogs', compact('genres'));
    }

    public function show(Request $request, Genre $genre)
    {
        $search = $request->input('search');

        $books = $genre->books()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->get();

        return view('genre.show', compact('genre', 'books'));
    }

    public function borrow($id)
    {
        // Fetch the book details using the provided ID
        $book = Book::find($id);

        // Check if the book exists
        if (!$book) {
            return redirect()->route('catalogs')->with('error', 'Book not found.');
        }

        // Return the view for borrowing the book, passing the book details
        return view('catalogs.book-borrow', compact('book'));
    }
}
