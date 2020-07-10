<?php

declare(strict_types=1);

namespace ManticoreSearch\Laravel;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Class Facade
 *
 * @package Cviebrock\LaravelManticoresearch
 */
class Facade extends BaseFacade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'manticoresearch';
    }
}
