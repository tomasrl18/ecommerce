<?php

use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\PaymentOrder;
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

Route::middleware(['auth'])->group(function () {
    Route::get('orders/create', CreateOrder::class)
        ->name('orders.create');
    Route::get('orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
    Route::get('orders/{order}/payment', PaymentOrder::class)
        ->name('orders.payment');
});
