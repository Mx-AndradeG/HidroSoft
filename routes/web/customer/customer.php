<?php

use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customer', CustomerController::class, ['names' => 'customer']);
Route::get('customer/export', [CustomerController::class, 'export'])->name('customer.export');

Route::inertia('/customers', 'Customer/CustomerIndex')->name('Customer');
