<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $books = Book::with('genre')->get();
        $borrowedBooks = BorrowedBook::with('book', 'user')->get();
        return view('admin.index', compact('books', 'borrowedBooks'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.create', compact('genres'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $coverImagePath = $request->file('cover_image')->store('images', 'public');

            Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'cover_image' => $coverImagePath,
                'genre_id' => $request->genre_id,
            ]);

            return redirect()->route('admin.index')->with('success', 'Book added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add book: ' . $e->getMessage());
        }
    }

    public function edit(Book $book)
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'nullable|string|max:255',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'genre_id' => 'required|exists:genres,id',
            ]);

            $data = [
                'title' => $request->title,
                'author' => $request->author,
                'genre_id' => $request->genre_id,
            ];

            if ($request->hasFile('cover_image')) {
                // Delete the old image
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')->store('images', 'public');
            }

            $book->update($data);

            return redirect()->route('admin.index')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }

    public function updateBorrowStatus(Request $request, BorrowedBook $borrowedBook)
    {
        try {
            $request->validate([
                'status' => 'required|in:borrowed,returned',
            ]);

            $borrowedBook->update([
                'status' => $request->status,
                'returned_at' => $request->status === 'returned' ? now() : null,
            ]);

            return redirect()->route('admin.index')->with('success', 'Borrow status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update borrow status: ' . $e->getMessage());
        }
    }
}