<?php

use App\Http\Controllers\PaymentMethod\PaymentMethodController;
use Illuminate\Support\Facades\Route;


Route::get('payment-method/branch/{id}', [PaymentMethodController::class, 'getPaymentMethod'])->name('payment-method.index');
Route::post('payment-method/branch', [PaymentMethodController::class, 'storePaymentMethods'])->name('payment-method.branch.store');


