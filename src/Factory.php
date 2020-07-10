<?php

declare(strict_types=1);

namespace ManticoreSearch\Laravel;

use Manticoresearch\Client;

class Factory
{
    /**
     * Make client and return Index object with all client methods
     *
     * @param array $connection List of settings for connecting to server(s)
     *
     * @return \ManticoreSearch\Client
     */
    public function make(array $connection): Client
    {
        return new Client($connection);
    }
}
