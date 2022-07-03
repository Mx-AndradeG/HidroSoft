<?php

use App\Http\Controllers\Stock\StocksController;
use Illuminate\Support\Facades\Route;

Route::get('stock/index', [StocksController::class, 'index'])->name('stock.index');

Route::inertia('/inventory', 'Inventory/InventoryIndex')->name('Inventory');