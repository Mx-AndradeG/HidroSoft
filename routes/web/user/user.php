<?php

use App\Http\Controllers\Notifications\NotificationsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('user/notification', [NotificationsController::class, 'index'])->name('notification.index');
Route::get('sale/notification/{id}', [NotificationsController::class, 'successNotification'])->name('sale.notification.viwed');
Route::get('user/index', [UserController::class, 'index'])->name('user.index');
Route::get('user/current-login-user', [UserController::class, 'getAuthUser'])->name('user.getAuthUser');
Route::get('user/info', [UserController::class, 'getCurrentAuthUser'])->name('user.current-login-user');
Route::get('user/export', [UserController::class, 'export'])->name('user.export');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
Route::post('user/account', [UserController::class, 'updateAccountData'])->name('user.account');
Route::post('user/account/passwd', [UserController::class, 'updateAccountPassword'])->name('user.account.passwd');
Route::apiResource('user', UserController::class, ['names' => 'user']);
Route::inertia('/user', 'User/UserIndex')->name('User');
