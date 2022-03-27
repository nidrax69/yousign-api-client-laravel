<?php

namespace Nidrax69\YousignApiLaravel;

use Illuminate\Support\Facades\Config;
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

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('yousignapi.laravel', function($app) {
        return new YousignApiLaravel();
      });
    }

}
