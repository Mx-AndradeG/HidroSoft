<?php

use App\Http\Controllers\PaymentMethod\PaymentMethodController;
use Illuminate\Support\Facades\Route;


Route::post('payment-method/branch', [PaymentMethodController::class, 'storePaymentMethods'])->name('payment-method.branch.store');

Route::get('payment-method/index', [PaymentMethodController::class, 'index'])->name('payment-method.index');


