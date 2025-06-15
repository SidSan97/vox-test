<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/boards', [BoardController::class, 'store'])->name('create.board');
Route::get('/boards', [BoardController::class, 'index'])->name('index.board');
Route::put('/boards/{id}', [BoardController::class, 'update'])->name('update.board');
Route::delete('/boards/{id}', [BoardController::class, 'delete'])->name('index.board');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('show.category');
Route::post('/categories', [CategoryController::class, 'store'])->name('store.category');

Route::get('/task/{id}', [TaskController::class, 'show'])->name('show.task');
Route::post('/task', [TaskController::class, 'store'])->name('store.task');
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('reorder.task');
Route::put('/task', [TaskController::class, 'edit'])->name('edit.task');
Route::delete('/task/{id}', [TaskController::class, 'delete'])->name('delete.task');
