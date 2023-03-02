<?php

use App\Http\Livewire\{CreateOrder, PaymentOrder, ShoppingCart};
use App\Models\Order;
use App\Http\Controllers\{CategoryController, OrderController, ProductsController, SearchController, WelcomeController};
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class);

Route::get('categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('products/{product}', [ProductsController::class, 'show'])
    ->name('products.show');

Route::get('search', SearchController::class)
    ->name('search');

Route::get('shopping-cart', ShoppingCart::class)
    ->name('shopping-cart');

Route::middleware(['auth'])->group(function () {
    Route::get('orders', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('orders/create', CreateOrder::class)
        ->name('orders.create');
    Route::get('orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
    Route::get('orders/{order}/payment', PaymentOrder::class)
        ->name('orders.payment');
});

Route::get('prueba', function () {
    $orders = Order::where('status', 1)
        ->where('created_at','<',now()
            ->subMinutes(10))->get();

    foreach ($orders as $order) {
        $items = json_decode($order->content);

        foreach ($items as $item) {
            increase($item);
        }

        $order->status = 5;

        $order->save();
    }

    return "Completado con éxito";
});
