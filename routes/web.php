<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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
    Route::put('/boards/{id}', [BoardController::class, 'update'])->name('update.board');
    Route::delete('/boards/{id}', [BoardController::class, 'delete'])->name('index.board');

    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('show.category');
    Route::post('/categories', [CategoryController::class, 'store'])->name('store.category');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('delete.category');
    Route::delete('/categories/{id}', [CategoryController::class, 'delete'])->name('delete.category');

    Route::get('/task/{id}', [TaskController::class, 'show'])->name('show.task');
    Route::post('/task', [TaskController::class, 'store'])->name('store.task');
    Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('reorder.task');
    Route::put('/task', [TaskController::class, 'edit'])->name('edit.task');
    Route::delete('/task/{id}', [TaskController::class, 'delete'])->name('delete.task');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
