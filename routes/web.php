<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');
