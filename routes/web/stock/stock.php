<?php

use App\Http\Controllers\Stock\StocksController;
use Illuminate\Support\Facades\Route;

Route::get('stock/index', [StocksController::class, 'index'])->name('stock.index');

Route::get('stock/export', [StocksController::class, 'export'])->name('stock.export');

Route::inertia('/inventory', 'Inventory/InventoryIndex')->name('Inventory');