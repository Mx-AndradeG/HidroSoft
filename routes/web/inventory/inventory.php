<?php

use App\Http\Controllers\InventoryMovement\InventoryMovementController;
use Illuminate\Support\Facades\Route;

Route::inertia('/inventory', 'Inventory/InventoryIndex')->name('Inventory');