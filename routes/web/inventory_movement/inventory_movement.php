<?php

use App\Http\Controllers\InventoryMovement\InventoryMovementController;
use Illuminate\Support\Facades\Route;

Route::get('inventory-movement/index', [InventoryMovementController::class, 'index'])->name('inventory-movement.index');

Route::apiResource('inventory-movement', InventoryMovementController::class, ['names' => 'inventory-movement']);

Route::inertia('/inventory-movements', 'InventoryMovement/InventoryMovementIndex')->name('InventoryMovement');