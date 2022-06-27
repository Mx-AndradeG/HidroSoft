<?php

use App\Http\Controllers\InventoryMovementType\InventoryMovementTypeController;
use Illuminate\Support\Facades\Route;


Route::get('inventory-movement-type/index', [InventoryMovementTypeController::class, 'index'])->name('inventory_movement_type.index');
