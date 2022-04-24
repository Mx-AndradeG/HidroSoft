<?php

use App\Http\Controllers\Suppliers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('supplier', [SupplierController::class, 'index'])->name('customer.index');

Route::apiResource('supplier', SupplierController::class, ['names' => 'customer']);

Route::inertia('/suppliers', 'Supplier/SupplierIndex')->name('Supplier');
