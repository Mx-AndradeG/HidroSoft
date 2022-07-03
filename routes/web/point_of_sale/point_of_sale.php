<?php

use App\Http\Controllers\Branch\BranchController;
use Illuminate\Support\Facades\Route;

Route::get('point-of-sale/index', [BranchController::class, 'index'])->name('point_of_sale.index');

Route::apiResource('point_of_sale', BranchController::class, ['names' => 'branch']);

Route::inertia('/point-of-sale', 'PointOfSale/PointOfSaleIndex')->name('PointOfSale');