<?php

use App\Http\Controllers\Storage\StorageController;
use Illuminate\Support\Facades\Route;

Route::get('storage/index', [StorageController::class, 'index'])->name('storage.index');

Route::apiResource('storage', StorageController::class, ['names' => 'storage']);

Route::inertia('/storage', 'Storage/StorageIndex')->name('Storage');