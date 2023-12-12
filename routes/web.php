<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Подтверждение почты
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//книги
Route::post('/books/{book}', [BookController::class, 'saveDuration'])->name('books.save-duration');

Route::get('/books/admin', [BookController::class, 'index'])->name('books.index');
Route::get('/books', [UserController::class, 'index'])->name('booksUser.index');
Route::get('/books/create/admin', [BookController::class, 'create'])->name('books.create');
Route::post('/books/create/admin', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/edit/admin', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('books', BookController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    
    Route::get('/books/admin', [BookController::class, 'index'])->name('books.index');
    Route::get('/books', [UserController::class, 'index'])->name('booksUser.index');
    Route::get('/books/create/admin', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit/admin', [BookController::class, 'edit'])->name('books.edit');
});

// Чирпсы
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);



require __DIR__.'/auth.php';
