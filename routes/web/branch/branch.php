<?php

use App\Http\Controllers\Branch\BranchController;
use Illuminate\Support\Facades\Route;

Route::get('branch/index', [BranchController::class, 'index'])->name('branch.index');

Route::get('branch/export', [BranchController::class, 'export'])->name('branch.export');

Route::apiResource('branch', BranchController::class, ['names' => 'branch']);

Route::inertia('/branch', 'Branch/BranchIndex')->name('Branch');