<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user's favorite books
        $favorites = Auth::user()->favorites ?? collect([]); // Fallback to an empty collection if no favorites

        // Pass the $favorites variable to the view
        return view('favorites', compact('favorites'));
    }
}