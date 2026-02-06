<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

// 1. الصفحة الرئيسية
Route::get('/', function () {
    $categories = Book::select('categorie')
        ->distinct()
        ->whereNotNull('categorie')
        ->where('categorie', '!=', '')
        ->orderBy('categorie', 'asc')
        ->pluck('categorie');
        
    return view('index', compact('categories'));
})->name('home');

// 2. صفحات ثابتة
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/about', function () { return view('about'); })->name('about');

// 3. عرض الكتب والبحث (للجميع)
// هاد الرابط هو اللي بغيتي: /book/index
Route::get('/book/index', [BookController::class, 'index'])->name('book.index');
Route::get('/books/{id}/details', [BookController::class, 'show'])->name('book.show');
Route::get('/search', [BookController::class, 'search'])->name('book.search');

// 4. Dashboard (مع جلب الـ Categories)
Route::get('/dashboard', function () {
    $categories = Book::select('categorie')
        ->distinct()
        ->whereNotNull('categorie')
        ->where('categorie', '!=', '')
        ->orderBy('categorie', 'asc')
        ->pluck('categorie');

    // تصحيح المسار للي قلتي ليا قبيلة
    return view('.dashboard', compact('categories'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 5. روابط المستخدم (Auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 6. روابط الأدمين (CRUD)
Route::middleware(['auth', 'admin'])->group(function () {
    // استعملنا 'book' بالمفرد باش يبقاو الروابط منسجمين
    Route::resource('book', BookController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';