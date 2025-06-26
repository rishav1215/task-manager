<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('dashboard');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});
Route::get('/login', [TaskController::class, 'showLoginForm'])->name('login');
Route::post('/login', [TaskController::class, 'login']);
Route::get('/register', [TaskController::class, 'register'])->name('register');


Route::post('/logout', [TaskController::class, 'logout'])->name('logout');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
