<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EcomExpressController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UnverifiedVendorController;
use App\Http\Controllers\IncompleteOrdersController;
use App\Http\Controllers\OrdersReturnController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\KDDeliveryController;


Route::get('/staff/login', [LoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [LoginController::class, 'login'])->name('staff.login.submit');
Route::post('/staff/logout', [LoginController::class, 'logout'])->name('staff.logout');
Route::redirect('/staff', '/staff/login');

// Using custom 'staff.auth' middleware
Route::prefix('staff')->middleware('staff.auth')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard.new');


    Route::get('/orders', [StaffController::class, 'orders'])->name('staff.orders');
    Route::get('/orders/data', [OrderController::class, 'getOrdersData'])->name('orders.data');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.new.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('/store', [StoreController::class, 'index'])->name('staff.store');
    Route::get('/vendor', [VendorController::class, 'index'])->name('staff.vendor');
    Route::get('/unverified-vendor', [UnverifiedVendorController::class, 'index'])->name('staff.unverifiedVendor');
    Route::get('/incomplete-orders', [IncompleteOrdersController::class, 'index'])->name('staff.incompleteOrders');
    Route::get('/orders-return', [OrdersReturnController::class, 'index'])->name('staff.ordersReturn');
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('staff.invoice');
    Route::get('/products', [ProductsController::class, 'index'])->name('staff.products');
    Route::get('/customers', [CustomersController::class, 'index'])->name('staff.customers');



    Route::get('/profile', [StaffController::class, 'profile'])->name('staff.profile');
    Route::get('/settings', [StaffController::class, 'settings'])->name('staff.settings');
});
Route::post('/send-order', [OrderController::class, 'sendOrder']);
Route::post('/fetch-waybill', [EcomExpressController::class, 'fetchWaybill']);
Route::post('/track-shipment/{trackingId}', [EcomExpressController::class, 'trackShipment']);
Route::post('/cancel-shipment', [EcomExpressController::class, 'cancelShipment']);

Route::get('/ecom/fetch-awb', [EcomExpressController::class, 'fetchAWBNumbers']);
Route::get('/ecom/send-manifest', [EcomExpressController::class, 'sendManifest']);

Route::get('/create-contacts/{orderId}', [KDDeliveryController::class, 'createContacts']);
Route::get('/create-order/{orderId}', [KDDeliveryController::class, 'createOrder']);
