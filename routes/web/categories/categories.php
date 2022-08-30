<?php

use App\Http\Controllers\Categories\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('categories/index', [CategoriesController::class, 'index'])->name('categories.index');

Route::get('categories/export', [CategoriesController::class, 'export'])->name('categories.export');

Route::apiResource('categories', CategoriesController::class, ['names' => 'categories']);

Route::inertia('/categories', 'Categories/CategoriesIndex')->name('Category');
