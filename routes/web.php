<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/board/{id}', 'board')->name('board.view');
    Route::view('/desktop', 'desktop')->name('desktop');

    Route::post('/boards', [BoardController::class, 'store'])->name('create.board');
    Route::get('/boards', [BoardController::class, 'index'])->name('index.board');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
