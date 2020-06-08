<?php

namespace ManticoreSearch\Laravel;

use Manticoresearch\Client;
use Manticoresearch\Index;

class Factory
{
    /**
     * Make client and return Index object with all client methods
     *
     * @param array $connection List of settings for connecting to server(s)
     *
     * @return \ManticoreSearch\Index
     */
    public function make(array $connection): Index
    {
        $client = new Client($connection);
        return new Index($client);
    }
}
