<?php

use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductBrandController;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductController;


Route::group([
  'prefix' => 'api',
  'middleware' => 'auth:api'
], function () {
  Route::resource('products', ProductController::class);
  Route::resource('product_brands', ProductBrandController::class);
});
