<?php

use App\Http\Controllers\Admin\{CategoryController, OrderController, ProductController};
use App\Http\Livewire\Admin\{BrandComponent, CreateProduct, EditProduct, ShowCategory, ShowProducts};
use Illuminate\Support\Facades\Route;

Route::get('/', ShowProducts::class)
    ->name('admin.index');

Route::get('products/{product}/edit', EditProduct::class)
    ->name('admin.products.edit');

Route::get('products/create', CreateProduct::class)
    ->name('admin.products.create');

Route::post('product/{product}/files', [ProductController::class, 'files'])
    ->name('admin.products.files');

Route::get('categories', [CategoryController::class, 'index'])
    ->name('admin.categories.index');

Route::get('categories/{category}', ShowCategory::class)
    ->name('admin.categories.show');

Route::get('brands', BrandComponent::class)
    ->name('admin.brands.index');

Route::get('orders', [OrderController::class, 'index'])
    ->name('admin.orders.index');

Route::get('orders/{order}', [OrderController::class, 'show'])
    ->name('admin.orders.show');
