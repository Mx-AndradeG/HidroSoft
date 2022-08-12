<?php

use App\Http\Controllers\InventoryMovement\InventoryMovementController;
use Illuminate\Support\Facades\Route;


Route::apiResource('inventory-movement', InventoryMovementController::class, ['names' => 'inventory-movement']);

Route::inertia('/inventory-movements', 'InventoryMovement/InventoryMovementIndex')->name('InventoryMovement');