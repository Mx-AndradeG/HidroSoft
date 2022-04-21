<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user/first-step', [UserController::class, 'validateFirstStep'])->name('user.first.step');
Route::post('user/second-step', [UserController::class, 'validateSecondStep'])->name('user.second.step');
