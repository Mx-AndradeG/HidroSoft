<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserType\UserTypeController;
use Illuminate\Support\Facades\Route;


Route::get('user-type/index', [UserTypeController::class, 'index'])->name('user_type.index');
