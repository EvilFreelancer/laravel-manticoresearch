[![Latest Stable Version](https://poser.pugx.org/evilfreelancer/laravel-manticoresearch/v/stable)](https://packagist.org/packages/evilfreelancer/laravel-manticoresearch)
[![Total Downloads](https://poser.pugx.org/evilfreelancer/laravel-manticoresearch/downloads)](https://packagist.org/packages/evilfreelancer/laravel-manticoresearch)
[![Build Status](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/badges/build.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/?branch=master)
[![Code Climate](https://codeclimate.com/github/EvilFreelancer/laravel-manticoresearch/badges/gpa.svg)](https://codeclimate.com/github/EvilFreelancer/laravel-manticoresearch)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/laravel-manticoresearch/?branch=master)
[![License](https://poser.pugx.org/evilfreelancer/laravel-manticoresearch/license)](https://packagist.org/packages/evilfreelancer/laravel-manticoresearch)

# Laravel ManticoreSearch plugin

An easy way to use the [official ManticoreSearch client](https://github.com/manticoresoftware/manticoresearch-php) in your Laravel or Lumen applications.

```sh
composer require evilfreelancer/laravel-manticoresearch
```

### Laravel

The package's service provider will automatically register its service provider.

Publish the configuration file:

```sh
php artisan vendor:publish --provider="ManticoreSearch\Laravel\ServiceProvider"
```

#### Alternative configuration method via .env file

After you publish the configuration file as suggested above, you may configure ManticoreSearch
by adding the following to your application's `.env` file (with appropriate values):
  
```ini
MANTICORESEARCH_HOST=localhost
MANTICORESEARCH_PORT=9200
MANTICORESEARCH_TRANSPORT=Http
MANTICORESEARCH_USER=
MANTICORESEARCH_PASS=
```

### Lumen

If you work with Lumen, please register the service provider and configuration in `bootstrap/app.php`:

```php
$app->register(ManticoreSearch\Laravel\ServiceProvider::class);
$app->configure('manticoresearch');
```

Manually copy the configuration file to your application.

## How to use

The `ManticoreSearch` facade is just an entry point into the [ManticoreSearch client](https://github.com/manticoresoftware/manticoresearch-php),
so previously you might have used:

```php
require_once __DIR__ . '/vendor/autoload.php';

$config = ['host'=>'127.0.0.1', 'port'=>9308];
$client = new \Manticoresearch\Client($config);
$index  = new \Manticoresearch\Index($client);
$index->setName('movies'); 
``` 

Instead of these few lines above you can use single line solution:

```php
$index = ManticoreSearch::index('movies');
```

That will run the command on the default connection. You can run a command on
any connection (see the `defaultConnection` setting and `connections` array in
the configuration file).

```php
$index   = ManticoreSearch::connection('connectionName')->index($nameOfIndex);
$pq      = ManticoreSearch::connection('connectionName')->pq();
$cluster = ManticoreSearch::connection('connectionName')->cluster();
$indices = ManticoreSearch::connection('connectionName')->indices();
$nodes   = ManticoreSearch::connection('connectionName')->nodes();

// etc...
```

methods of Client class:

```php
ManticoreSearch::connection('connectionName')->sql($params);
ManticoreSearch::connection('connectionName')->replace($params);
ManticoreSearch::connection('connectionName')->delete($params);

// etc...
```

Lumen users who aren't using facades will need to use dependency injection,
or the application container in order to get the ManticoreSearch Index object:

```php
// using injection:
public function handle(\ManticoreSearch\Laravel\Manager $manticoresearch)
{
    $manticoresearch->describe();
}

// using application container:
$manticoreSearch = $this->app('manticoresearch');
```

Of course, dependency injection and the application container work 
for Laravel applications as well.

## All available environments variables

| Name                               | Default value  | Description | 
|------------------------------------|----------------|-------------|
| MANTICORESEARCH_CONNECTION         | default        | Name of default connection |
| MANTICORESEARCH_HOST               | localhost      | Address of host with Manticore server |
| MANTICORESEARCH_PORT               | 9308           | Port number with REST server |
| MANTICORESEARCH_TRANSPORT          | Http           | Type of transport, can be: Http, Https, PhpHttp or your custom driver |
| MANTICORESEARCH_USER               |                | Username |
| MANTICORESEARCH_PASS               |                | Password |
| MANTICORESEARCH_TIMEOUT            | 5              | Timeout between requests |
| MANTICORESEARCH_CONNECTION_TIMEOUT | 1              | Timeout before connection |
| MANTICORESEARCH_PROXY              |                | Url of HTTP proxy server |
| MANTICORESEARCH_PERSISTENT         | true           | Define whenever connection is persistent or not |
| MANTICORESEARCH_RETRIES            | 2              | Amount of retries if connection is lost |

## Links

* https://github.com/manticoresoftware/manticoresearch-php
* https://github.com/cviebrock/laravel-elasticsearch
