<?php

use App\Http\Controllers\Storage\StorageController;
use Illuminate\Support\Facades\Route;

Route::get('inventory/index', [StorageController::class, 'index'])->name('inventory.index');

Route::apiResource('inventory', StorageController::class, ['names' => 'inventory']);

Route::inertia('/inventory', 'Inventory/InventoryIndex')->name('Inventory');