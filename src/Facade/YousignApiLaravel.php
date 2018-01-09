<?php namespace Nidrax69\YousignApiLaravel\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class YousignApiLaravel extends BaseFacade {

    protected static function getFacadeAccessor() { return 'yousignapi.laravel'; }

}
