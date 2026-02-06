<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

// Routes publiques (accessibles à tous)
// Route::get('/', function () {
//     return view('index');
// })->name('index');

Route::get('/', function () {
    $categories = Book::select('categorie')
        ->distinct()
        ->whereNotNull('categorie')
        ->where('categorie', '!=', '')
        ->orderBy('categorie', 'asc')
        ->pluck('categorie');
        
    return view('index', compact('categories'));
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');

// this is for get livers if the visitor not connected (looged in)

Route::get('/books', [BookController::class, 'index'])
        ->name('book.index');

// this for show details of book if the visitor not connected (looged in)
Route::get('/books/{id}/details', [BookController::class, 'show'])
        ->name('book.show');

// // this for search for book 
Route::get('/search', [BookController::class, 'search'])->name('book.search');


// Routes pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    // Page de profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    // Consultation des livres (tous les utilisateurs connectés)
    // Route::get('/books', [BookController::class, 'index'])
    //     ->name('book.index');
   
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes CRUD réservées aux admins
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('book', BookController::class)
        ->except(['index', 'show']);
});

require __DIR__.'/auth.php';
