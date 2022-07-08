<?php

use App\Http\Controllers\Sale\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('sale/index', [SalesController::class, 'index'])->name('sales.index');

Route::apiResource('sales', SalesController::class, ['names' => 'sales']);

