# YouSignApiLaravel

[![Latest Stable Version](https://poser.pugx.org/nidrax69/yousign-api-laravel/v/stable)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![Total Downloads](https://poser.pugx.org/nidrax69/yousign-api-laravel/downloads)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![Latest Unstable Version](https://poser.pugx.org/nidrax69/yousign-api-laravel/v/unstable)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![License](https://poser.pugx.org/nidrax69/yousign-api-laravel/license)](https://packagist.org/packages/nidrax69/yousign-api-laravel)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=D93LM77M9EWCS)

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
composer require nidrax69/yousign-api-laravel
```

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
