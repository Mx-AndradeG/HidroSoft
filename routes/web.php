<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__ . '/web/without_auth/auth.php';

Route::redirect('/', '/login')->name('website.index');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    require __DIR__ . '/web/dashboard/dashboard.php';
    require __DIR__ . '/web/company/company.php';
    require __DIR__ . '/web/branch/branch.php';
    require __DIR__ . '/web/categories/categories.php';
    require __DIR__ . '/web/customer/customer.php';
    require __DIR__ . '/web/suppliers/suppliers.php';
    require __DIR__ . '/web/products/products.php';
    require __DIR__ . '/web/payment_method/payment_method.php';
    require __DIR__ . '/web/storage/storage.php';
    require __DIR__ . '/web/user/user.php';
    require __DIR__ . '/web/user_type/user_type.php';
    require __DIR__ . '/web/stock/stock.php';
    require __DIR__ . '/web/inventory_movement_types/inventory_movement_types.php';
    require __DIR__ . '/web/point_of_sale/point_of_sale.php';
    require __DIR__ . '/web/inventory_movement/inventory_movement.php';
});
