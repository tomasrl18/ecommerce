<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Livewire\Admin\{CreateProduct, EditProduct, ShowProducts};
use Illuminate\Support\Facades\Route;

Route::get('/', ShowProducts::class)
    ->name('admin.index');

Route::get('products/{product}/edit', EditProduct::class)
    ->name('admin.products.edit');

Route::get('products/create', CreateProduct::class)
    ->name('admin.products.create');

Route::post('product/{product}/files', [ProductController::class, 'files'])
    ->name('admin.products.files');
