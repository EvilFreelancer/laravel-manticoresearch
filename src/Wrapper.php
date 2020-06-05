<?php

namespace LaravelManticoreSearch;

use Manticoresearch\Client;

class Wrapper
{
    /**
     * @param array $params
     *
     * @return \Manticoresearch\Client
     */
    public function getClient(array $params = []): Client
    {
        // Read configs from
        $configs = config('manticoresearch');
        $configs = array_merge($configs, $params);

        // Read default connections and other things required for manticore
        $defaultConnection = $configs['defaultConnection'];

        // Read hosts configuration by default connection name
        $connections = $configs['connections'][$defaultConnection]['hosts'];

        // Return client with provided connections
        return new Client($connections);
    }
}
