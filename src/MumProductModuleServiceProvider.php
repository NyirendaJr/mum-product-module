<?php

namespace Thelabdevtz\MumProductModule;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Thelabdevtz\MumProductModule\Http\Controllers\ProductController;

class MumProductModuleServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   */
  public function boot()
  {
    /*
         * Optional methods to load your package assets
         */
    // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mum-product-module');
    // $this->loadViewsFrom(__DIR__.'/../resources/views', 'mum-product-module');
    $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

    if ($this->app->runningInConsole()) {

      //            $this->publishes([
      //                __DIR__.'/../config/config.php' => config_path('mum-product-module.php'),
      //            ], 'config');

      // Publishing the views and components.
      $this->publishes([
        __DIR__ . '/../resources/assets/js/components' => resource_path('js/vendor/mum-product-module/components'),
      ], 'product-module-components');

      // Publishing single page routes.
      $this->publishes([
        __DIR__ . '/../resources/assets/js/routes' => resource_path('js/vendor/mum-product-module'),
      ], 'product-module-spa-routes');

      // Publishing module store.
      $this->publishes([
        __DIR__ . '/../resources/assets/js/store' => resource_path('js/vendor/mum-product-module/store'),
      ], 'product-module-store');

      // Registering package commands.
      // $this->commands([]);
    }

    //Route::get('mum', ProductController::class);
  }

  /**
   * Register the application services.
   */
  public function register()
  {
    // Automatically apply the package configuration
    $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'mum-product-module');

    // Register the main class to use with the facade
    $this->app->singleton('mum-product-module', function () {
      return new MumProductModule;
    });
  }
}
