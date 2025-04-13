<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
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
    Route::get('/catalogs/{genre}', [CatalogController::class, 'show'])->name('genre.show');
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs');

    // Book borrowing route
    Route::post('/books/borrow/{book}', [BookController::class, 'borrow'])->name('books.borrow');

    // Genre route
    Route::get('/genre/{id}', [BookController::class, 'show'])->name('genre.show');

    // Transaction route
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    

    // Favorites route
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{book}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{book}', [AdminController::class, 'update'])->name('admin.update');
        Route::put('/borrow-status/{borrowedBook}', [AdminController::class, 'updateBorrowStatus'])->name('admin.borrowed.update');
    });

    // Additional admin routes (if needed)
    Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/books', [BookController::class, 'adminIndex'])->name('books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::patch('/books/{book}/toggle', [BookController::class, 'toggleStatus'])->name('books.toggle');
    });

    // routes/web.php
    Route::post('/admin/update-borrowed-status/{borrowedBook}', [App\Http\Controllers\AdminController::class, 'updateBorrowStatus'])
    ->middleware(['auth', 'admin'])
    ->name('admin.updateBorrowStatus');
    Route::post('/admin/mark-as-paid/{borrowedBook}', [App\Http\Controllers\AdminController::class, 'markAsPaid'])->middleware(['auth', 'admin'])->name('admin.markAsPaid');
    Route::get('/admin/adjust-stock/{book}', [App\Http\Controllers\AdminController::class, 'adjustStock'])->middleware(['auth', 'admin'])->name('admin.adjustStock');
    Route::post('/admin/update-stock/{book}', [App\Http\Controllers\AdminController::class, 'updateStock'])->middleware(['auth', 'admin'])->name('admin.updateStock');
    Route::post('/dashboard/borrow/{book}', [App\Http\Controllers\DashboardController::class, 'borrow'])->middleware('auth')->name('dashboard.borrow');
});

require __DIR__.'/auth.php';