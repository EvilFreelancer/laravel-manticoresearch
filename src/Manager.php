<?php

declare(strict_types=1);

namespace ManticoreSearch\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Manticoresearch\Client;

/**
 * Class Manager
 *
 * @package ManticoreSearch\Laravel
 */
class Manager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * The Manticoresearch connection factory instance.
     *
     * @var \ManticoreSearch\Laravel\Factory
     */
    protected $factory;

    /**
     * The active connection instances.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \ManticoreSearch\Laravel\Factory          $factory
     */
    public function __construct(Container $app, Factory $factory)
    {
        $this->app     = $app;
        $this->factory = $factory;
    }

    /**
     * Retrieve or build the named connection.
     *
     * @param string|null $name Name of connection
     *
     * @return \ManticoreSearch\Client
     */
    public function connection(string $name = null): Client
    {
        $name = $name ?: $this->getDefaultConnection();

        if (!isset($this->connections[$name])) {
            $client = $this->makeConnection($name);

            $this->connections[$name] = $client;
        }

        return $this->connections[$name];
    }

    /**
     * Get the default connection.
     *
     * @return string
     */
    public function getDefaultConnection(): string
    {
        return $this->app['config']['manticoresearch.defaultConnection'];
    }

    /**
     * Set the default connection.
     *
     * @param string $connection
     */
    public function setDefaultConnection(string $connection): void
    {
        $this->app['config']['manticoresearch.defaultConnection'] = $connection;
    }

    /**
     * Make a new connection.
     *
     * @param string $name Name of connection
     *
     * @return \ManticoreSearch\Client
     */
    protected function makeConnection(string $name): Client
    {
        $config = $this->getConfig($name);

        return $this->factory->make($config);
    }

    /**
     * Get the configuration for a named connection.
     *
     * @param string $name Name of connection
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function getConfig(string $name)
    {
        $connections = $this->app['config']['manticoresearch.connections'];

        if (null === $config = Arr::get($connections, $name)) {
            throw new InvalidArgumentException("ManticoreSearch connection [$name] not configured.");
        }

        return $config;
    }

    /**
     * Return all of the created connections.
     *
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * Return all of the created connections.
     *
     * @return \Manticoresearch\Client
     */
    public function client(): Client
    {
        return $this->connection();
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }
}
