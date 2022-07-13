<?php

use App\Http\Controllers\Storage\StorageController;
use Illuminate\Support\Facades\Route;

Route::get('wherehouses/index', [StorageController::class, 'index'])->name('wherehouses.index');

Route::apiResource('wherehouses', StorageController::class, ['names' => 'wherehouses']);

Route::inertia('/wherehouses', 'Storage/StorageIndex')->name('Wherehouses');