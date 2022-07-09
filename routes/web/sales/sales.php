<?php

use App\Http\Controllers\Sale\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('sale/index', [SalesController::class, 'index'])->name('sales.index');

Route::get('sale/sales-header-info', [SalesController::class, 'getHeaderInfoDashboard'])->name('sales.header.info');

Route::get('sale/sales-pie-chart-info', [SalesController::class, 'chartPieDataDashboard'])->name('sales.pie.info');

Route::get('sale/sales-bar-chart-info', [SalesController::class, 'barDataChartDashboard'])->name('sales.bar.info');

Route::get('sale/most-erned-per-product', [SalesController::class, 'mostEarnedPerProduct'])->name('sales.erned.product');

Route::apiResource('sales', SalesController::class, ['names' => 'sales']);

