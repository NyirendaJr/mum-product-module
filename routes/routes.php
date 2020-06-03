<?php

use Illuminate\Support\Facades\Route;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductBrandController;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductController;

Route::prefix('mum')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('product_brands', ProductBrandController::class);
});
