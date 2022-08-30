<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User\UserController;

Route::get('user/user-profile', [UserController::class, 'getProfileIndexPage'])->name('UserProfile');

