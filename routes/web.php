<?php

use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\ShoppingCart;
use App\Http\Controllers\{CategoryController, OrderController, ProductsController, SearchController, WelcomeController};
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class);

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

Route::get('categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('products/{product}', [ProductsController::class, 'show'])
    ->name('products.show');

Route::get('search', SearchController::class)
    ->name('search');

Route::get('shopping-cart', ShoppingCart::class)
    ->name('shopping-cart');

Route::get('orders/create', CreateOrder::class)
    ->middleware('auth')
    ->name('orders.create');

Route::get('orders/{order}/payment', [OrderController::class, 'payment'])
    ->name('orders.payment');
