<?php

/**
 * Default configuration of ManticoreSearch client, all available parameters
 * can be found here https://github.com/manticoresoftware/manticoresearch-php/blob/master/docs/configuration.md
 */
return [

    'defaultConnection' => env('MANTICORESEARCH_CONNECTION', 'default'),

    'connections' => [

        // Default connection which will be used with environment variables
        'default' => [
            'host'               => env('MANTICORESEARCH_HOST', 'localhost'),
            'port'               => env('MANTICORESEARCH_PORT', 9308),
            'transport'          => env('MANTICORESEARCH_TRANSPORT', 'Http'),
            'username'           => env('MANTICORESEARCH_USER', null),
            'password'           => env('MANTICORESEARCH_PASS', null),
            'timeout'            => env('MANTICORESEARCH_TIMEOUT', 5),
            'connection_timeout' => env('MANTICORESEARCH_CONNECTION_TIMEOUT', 1),
            'proxy'              => env('MANTICORESEARCH_PROXY', null),
            'persistent'         => env('MANTICORESEARCH_PERSISTENT', true),

            /** @link https://github.com/manticoresoftware/manticoresearch-php/blob/master/docs/configuration.md#retries */
            'retries'            => env('MANTICORESEARCH_RETRIES', 2),
        ],

        // Second connection which will use list of hosts and minimal settings
        'second'  => [
            'hosts' => [
                'host'      => 'localhost',
                'port'      => 9308,
                'transport' => 'Http',
            ],
        ],

    ],

];
