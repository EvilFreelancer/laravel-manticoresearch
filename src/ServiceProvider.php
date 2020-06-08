<?php

namespace ManticoreSearch\Laravel;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Manticoresearch\Index;

/**
 * Class ServiceProvider
 *
 * @package ManticoreSearch\Laravel
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $source = __DIR__ . '/../config/manticoresearch.php';

        if ($this->app instanceof LaravelApplication) {
            $this->publishes([$source => config_path('manticoresearch.php')], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('manticoresearch');
        }

        $this->mergeConfigFrom($source, 'manticoresearch');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $app = $this->app;

        $app->singleton('manticoresearch.factory', static function ($app) {
            return new Factory();
        });

        $app->singleton('manticoresearch', static function ($app) {
            return new Manager($app, $app['manticoresearch.factory']);
        });

        $app->alias('manticoresearch', Manager::class);

        $app->singleton(Index::class, function (Container $app) {
            return $app->make('manticoresearch')->connection();
        });
    }
}
