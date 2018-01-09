# YouSignApiLaravel

[![Latest Stable Version](https://poser.pugx.org/nidrax69/yousign-api-laravel/v/stable)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![Total Downloads](https://poser.pugx.org/nidrax69/yousign-api-laravel/downloads)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![Latest Unstable Version](https://poser.pugx.org/nidrax69/yousign-api-laravel/v/unstable)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![License](https://poser.pugx.org/nidrax69/yousign-api-laravel/license)](https://packagist.org/packages/nidrax69/yousign-api-laravel)

It's a library for Laravel 5.5. and PHP7
Not tested on previous version.

Library to use YouSign API with Laravel
Based on PHP Client : https://github.com/Yousign/yousign-api-client-php

Updated version of : https://github.com/wooxo/yousign-api-client-laravel

Installation
------------

Install using composer

Now require the lib
```bash
composer require nidrax69/yousign-api-laravel 1.0
```

You will experience Warning during installation.
I'm using a new SOAP package for php7.
https://github.com/Yousign/yousign-api-client-php using deprecated function of PHP7 inside their depedencies
Feel free to help me how to configure that.

Add provider in config.app
```bash
'providers' => [
    Nidrax69\YousignApiLaravel\YousignApiLaravelServiceProvider::class,
];

'aliases' => [
    'YousignApiLaravel' => Nidrax69\YousignApiLaravel\Facade\YousignApiLaravel::class,
];
```

Complete informations inside /config/yousign.php (contact YouSign to get Credentials) and then
```bash
php artisan vendor:publish
```

Usage
------------

Init connection
```php
use Nidrax69\YousignApiLaravel\YousignApiLaravel;

class DocumentController extends Controller
{

  public function connexion(Request $request) {
    $client = new YousignApiLaravel();
    $client->connect();
  }
}
```

After please report to the documentation of https://github.com/Yousign/yousign-api-client-php
