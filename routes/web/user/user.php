<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('user/index', [UserController::class, 'index'])->name('user.index');

Route::apiResource('user', UserController::class, ['names' => 'user']);

Route::inertia('/user', 'User/UserIndex')->name('User');

