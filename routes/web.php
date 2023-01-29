<?php

use App\Http\Livewire\ShoppingCart;
use App\Http\Controllers\{CategoryController, ProductsController, SearchController, WelcomeController};
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('products/{product}', [ProductsController::class, 'show'])
    ->name('products.show');

Route::get('/deletecart', function () {
    \Cart::destroy();
});

Route::get('search', SearchController::class)
    ->name('search');

Route::get('shopping-cart', ShoppingCart::class)
    ->name('shopping-cart');
