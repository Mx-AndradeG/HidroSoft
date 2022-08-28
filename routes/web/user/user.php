<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('user/index', [UserController::class, 'index'])->name('user.index');
Route::get('user/current-login-user', [UserController::class, 'getAuthUser'])->name('user.getAuthUser');
Route::get('user/info', [UserController::class, 'getCurrentAuthUser'])->name('user.current-login-user');
Route::get('user/export', [UserController::class, 'export'])->name('user.export');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
Route::put('user/{user}/account', [UserController::class, 'updateAccountData'])->name('user.account');
Route::apiResource('user', UserController::class, ['names' => 'user']);
Route::inertia('/user', 'User/UserIndex')->name('User');
