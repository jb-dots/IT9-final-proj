<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\GenreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (main authenticated page)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Home route (redirects to dashboard)
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // Catalog routes
    Route::get('/catalogs/selection', [CatalogController::class, 'selection'])->name('catalog.selection');
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs');

    // Genre route (for genre page, show.blade.php)
    Route::get('/genres/{id}', [BookController::class, 'showGenre'])->name('genre.show');

    // Book routes
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show'); // For description.blade.php
    Route::post('/books/borrow/{book}', [BookController::class, 'borrow'])->name('books.borrow');
    Route::post('/books/{id}/rate', [BookController::class, 'rateBook'])->name('books.rate');

    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/books/{book}/favorites', [BookController::class, 'addToFavorites'])->name('favorites.add');

    // Transaction route
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes (consolidated)
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{book}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{book}', [AdminController::class, 'update'])->name('admin.update');
        Route::post('/borrow-status/{borrowedBook}', [AdminController::class, 'updateBorrowStatus'])->name('admin.updateBorrowStatus');
        Route::post('/mark-as-paid/{borrowedBook}', [AdminController::class, 'markAsPaid'])->name('admin.markAsPaid');
        Route::get('/adjust-stock/{book}', [AdminController::class, 'adjustStock'])->name('admin.adjustStock');
        Route::post('/update-stock/{book}', [AdminController::class, 'updateStock'])->name('admin.updateStock');
    
        Route::get('/books', [BookController::class, 'adminIndex'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
        Route::patch('/books/{book}/toggle', [BookController::class, 'toggleStatus'])->name('admin.books.toggle');
    
        Route::get('/genres/create', [GenreController::class, 'create'])->name('admin.genres.create');
        Route::post('/genres/store', [GenreController::class, 'store'])->name('admin.genres.store');
        Route::get('/genres/{genre}/edit', [GenreController::class, 'edit'])->name('admin.genres.edit');
        Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('admin.genres.update');
        Route::delete('/genres/{genre}', [GenreController::class, 'destroy'])->name('admin.genres.destroy');
    });
    
    // Dashboard borrow route
    Route::post('/dashboard/borrow/{book}', [DashboardController::class, 'borrow'])->name('dashboard.borrow');
});

require __DIR__.'/auth.php';