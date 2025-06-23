<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');           // List users
    Route::get('/create', [UserController::class, 'create'])->name('create');   // Show create form
    Route::post('/', [UserController::class, 'store'])->name('store');          // Store new user
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');  // Show edit form
    Route::put('/{user}', [UserController::class, 'update'])->name('update');   // Update user
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // Delete user
    Route::put('/{user}/status', [UserController::class, 'toggleStatus'])->name('toggleStatus'); // Active/inactive
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
