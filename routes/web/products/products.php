<?php

use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('product', [ProductController::class, 'index'])->name('product.index');

Route::apiResource('product', ProductController::class, ['names' => 'product']);

Route::inertia('/products', 'Product/ProductIndex')->name('Product');
