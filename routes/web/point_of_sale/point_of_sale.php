<?php

use App\Http\Controllers\Branch\BranchController;
use Illuminate\Support\Facades\Route;


Route::apiResource('point_of_sale', BranchController::class, ['names' => 'branch']);

Route::inertia('/point-of-sale', 'PointOfSale/PointOfSaleIndex')->name('PointOfSale');