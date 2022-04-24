<?php

use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('customer/index', [CustomerController::class, 'index'])->name('customer.index');

Route::apiResource('customer', CustomerController::class, ['names' => 'customer']);

Route::inertia('/customers', 'Customer/CustomerIndex')->name('Customer');
