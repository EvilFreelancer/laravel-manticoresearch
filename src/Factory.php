<?php

declare(strict_types=1);

namespace ManticoreSearch\Laravel;

use Manticoresearch\Client;
use Psr\Log\LoggerInterface;

class Factory
{
    /**
     * Make client and return Index object with all client methods
     *
     * @param array $connection List of settings for connecting to server(s)
     * @param \Psr\Log\LoggerInterface|null $logger You may use any PSR logger in your application
     *
     * @return \ManticoreSearch\Client
     */
    public function make(array $connection, LoggerInterface $logger = null): Client
    {
        return new Client($connection, $logger);
    }
}
