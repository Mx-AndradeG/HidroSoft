<?php

use App\Http\Controllers\Suppliers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('supplier/export', [SupplierController::class, 'export'])->name('supplier.export');

Route::apiResource('supplier', SupplierController::class, ['names' => 'supplier']);

Route::inertia('/suppliers', 'Supplier/SupplierIndex')->name('Supplier');
