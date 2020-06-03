<?php

use Illuminate\Support\Facades\Route;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductController;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductBrandController;

Route::prefix('mum')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('product_brands', ProductBrandController::class);
});
