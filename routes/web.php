<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
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

    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs');
    Route::get('/genres/{genre}', [CatalogController::class, 'show'])->name('genre.show');
    Route::get('/catalogs/borrow/{id}', [CatalogController::class, 'borrow'])->name('catalogs.borrow');
    Route::post('/catalogs/borrow/{id}', [CatalogController::class, 'storeBorrow'])->name('catalogs.borrow.store');
    
    // Book routes
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show'); // For description.blade.php
    Route::post('/books/borrow/{book}', [BookController::class, 'borrow'])->name('books.borrow');

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

    // Admin routes (combined both groups and standardized on 'role:admin')
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
        // Main Admin Routes
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{book}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{book}', [AdminController::class, 'update'])->name('admin.update');
        Route::get('/adjust-stock/{book}', [AdminController::class, 'adjustStock'])->name('admin.adjustStock');
        Route::post('/update-stock/{book}', [AdminController::class, 'updateStock'])->name('admin.updateStock');
        Route::post('/update-borrow-status/{borrowedBook}', [AdminController::class, 'updateBorrowStatus'])->name('admin.updateBorrowStatus');
        Route::post('/mark-as-paid/{borrowedBook}', [AdminController::class, 'markAsPaid'])->name('admin.markAsPaid');
    
        // Genre Routes
        Route::get('/genres/create', [AdminController::class, 'createGenre'])->name('admin.genres.create');
        Route::post('/genres', [AdminController::class, 'storeGenre'])->name('admin.genres.store');
        Route::get('/genres/{genre}/edit', [AdminController::class, 'editGenre'])->name('admin.genres.edit');
        Route::put('/genres/{genre}', [AdminController::class, 'updateGenre'])->name('admin.genres.update');
        Route::delete('/genres/{genre}', [AdminController::class, 'destroyGenre'])->name('admin.genres.destroy');

        // Additional Admin Book Routes (previously using 'admin' middleware)
        Route::get('/books', [BookController::class, 'adminIndex'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
        Route::patch('/books/{book}/toggle', [BookController::class, 'toggleStatus'])->name('admin.books.toggle');
    });

    // Dashboard borrow route
    Route::post('/dashboard/borrow/{book}', [DashboardController::class, 'borrow'])->name('dashboard.borrow');
});

require __DIR__.'/auth.php';