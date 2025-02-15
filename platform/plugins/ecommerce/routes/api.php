<?php

use Botble\Ecommerce\Http\Controllers\API\BrandController;
use Illuminate\Support\Facades\Route;
use Botble\Ecommerce\Http\Controllers\API\ProductController;
use Botble\Ecommerce\Http\Controllers\API\ProductCategoryController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1/ecommerce/',
    'namespace' => 'Botble\Ecommerce\Http\Controllers\API',
], function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{slug}', [ProductController::class, 'show']);

    Route::get('product-categories', [ProductCategoryController::class, 'index']);
    Route::get('product-categories/{slug}', [ProductCategoryController::class, 'show']);
    Route::get('product-categories/{id}/products', [ProductCategoryController::class, 'products']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('brands/{slug}', [BrandController::class, 'show']);
    Route::get('brands/{id}/products', [BrandController::class, 'products']);
});
