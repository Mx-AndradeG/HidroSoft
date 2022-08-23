<?php

use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('product', [ProductController::class, 'index'])->name('product.index');
Route::get('product/export', [ProductController::class, 'export'])->name('product.export');

Route::apiResource('product', ProductController::class, ['names' => 'product']);

Route::inertia('/products', 'Product/ProductIndex')->name('Product');
