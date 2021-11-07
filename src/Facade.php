<?php

declare(strict_types=1);

namespace ManticoreSearch\Laravel;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Class Facade
 *
 * @package ManticoreSearch\Laravel
 */
class Facade extends BaseFacade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return 'manticoresearch';
    }
}
