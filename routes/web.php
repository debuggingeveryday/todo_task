<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authorize;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::resource('/user-management', UserController::class)->middleware('is_admin');
    Route::resource('/todo-task', TodoController::class)->middleware('is_staff');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
