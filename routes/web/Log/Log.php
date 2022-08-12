<?php

use App\Http\Controllers\Log\LogsController;
use Illuminate\Support\Facades\Route;

Route::get('Log', [LogsController::class, 'index'])->name('Log.index');
Route::get('Log/export', [LogsController::class, 'export'])->name('Log.export');

Route::inertia('/log', 'Log/LogIndex')->name('Log');
