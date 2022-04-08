<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes withoutAuth
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Inertia::render('Home', [ 'title' => 'Homepage',]);
})->name('homepage');
Route::get('/login', function () {
    return Inertia::render('Auth/Login', [ 'title' => 'Login',]);
})->name('login');
Route::get('/register', function () {
    return Inertia::render('Auth/Register', [ 'title' => 'Register',]);
})->name('register');
