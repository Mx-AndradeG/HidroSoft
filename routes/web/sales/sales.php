<?php

use App\Http\Controllers\Sale\SalesController;
use Illuminate\Support\Facades\Route;


Route::get('sale/sales-header-info', [SalesController::class, 'getHeaderInfoDashboard'])->name('sales.header.info');

Route::get('sale/preview-calculate-dates', [SalesController::class, 'calculateDates'])->name('sales.calculate.payments');

Route::get('sale/sales-pie-chart-info', [SalesController::class, 'chartPieDataDashboard'])->name('sales.pie.info');

Route::get('sale/sales-bar-chart-info', [SalesController::class, 'barDataChartDashboard'])->name('sales.bar.info');

Route::get('sale/most-erned-per-product', [SalesController::class, 'mostEarnedPerProduct'])->name('sales.erned.product');

Route::get('sale/payments-dates-current', [SalesController::class, 'getSalesDates'])->name('sales.payments.dates.current');

Route::get('sale/export', [SalesController::class, 'export'])->name('sales.export');

Route::get('sale/print/ticket/{id}', [SalesController::class, 'ticketInfo'])->name('sales.print.ticket');

Route::post('sale/store-payment', [SalesController::class, 'storePayment'])->name('sales.store.payment');

Route::apiResource('sales', SalesController::class, ['names' => 'sales']);

