<?php

namespace LaravelManticoreSearch;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Class Facade
 *
 * @package Cviebrock\LaravelElasticsearch
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
