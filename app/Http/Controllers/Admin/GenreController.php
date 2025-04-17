<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function create()
    {
        return view('admin.add-genre');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres',
        ]);

        Genre::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.index')->with('success', 'Genre added successfully.');
    }

    public function edit(Genre $genre)
    {
        return view('admin.edit-genre', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.index')->with('success', 'Genre updated successfully.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('admin.index')->with('success', 'Genre deleted successfully.');
    }
}