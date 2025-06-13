<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\StatusController;

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');
    
    Route::get('/priorities', [PriorityController::class, 'index'])->name('priority.index');
    Route::get('/priorities/create', [PriorityController::class, 'create'])->name('priority.create');
    Route::get('/priorities/{id}/edit', [PriorityController::class, 'edit'])->name('priority.edit');
    Route::get('/priorities/{id}', [PriorityController::class, 'show'])->name('priority.show');

    Route::get('/statuses', [StatusController::class, 'index'])->name('status.index');
    Route::get('/statuses/create', [StatusController::class, 'create'])->name('status.create');
    Route::get('/statuses/{id}/edit', [StatusController::class, 'edit'])->name('status.edit');
    
    
    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('task.show');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
