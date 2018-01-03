<?php

namespace Nidrax69\YousignApiLaravel;

use Illuminate\Support\ServiceProvider;

class YousignApiLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
        __DIR__.'/../config/config.php' => public_path('yousign.php'),
      ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      // Config
      $this->mergeConfigFrom( __DIR__.'/config/config.php', 'yousignapi.config');

      $this->app->bind('yousignapi.laravel', function($app) {
        return new YousignApiLaravel();
      });
    }
}
