<?php

namespace Nidrax69\YousignApiLaravel;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class YousignApiLaravelServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
        __DIR__.'/config/config.php' => config_path('yousign.php'),
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
      $this->mergeConfigFrom( __DIR__.'/config/config.php', config_path('yousign.php'));

      $this->app->bind('yousignapi.laravel', function($app) {
        return new YousignApiLaravel();
      });
    }

    public function provides() {
      return array('yousignapi.laravel');
    }
}
