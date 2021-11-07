<?php

namespace Tests\ManticoreSearch\Laravel;

use ManticoreSearch\Laravel\Facade;
use ManticoreSearch\Laravel\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageAliases($app): array
    {
        return [
            'ManticoreSearch' => Facade::class,
        ];
    }
}
