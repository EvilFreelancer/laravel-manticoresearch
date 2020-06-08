<?php

namespace ManticoreSearch\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use Manticoresearch\Index;

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
     * @return \ManticoreSearch\Index
     */
    public function connection(string $name = null): Index
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
     * @return \ManticoreSearch\Index
     */
    protected function makeConnection(string $name): Index
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
            throw new \InvalidArgumentException("ManticoreSearch connection [$name] not configured.");
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
        $index->updateDocument(['year' => 2019], ['match' => ['*' => 'team']]);

        return $this->connections;
    }

    /**
     * Instantiate Index object, pass name of index if need
     *
     * @param string $name Index name
     *
     * @return \Manticoresearch\Index
     */
    public function index(string $name = null): Index
    {
        $index = $this->connection();

        if (null !== $name) {
            $index->setName($name);
        }

        $index->addDocuments([
            ['id' => 2, 'title' => 'Interstellar', 'plot' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 'year' => 2014, 'rating' => 8.5],
            ['id' => 3, 'title' => 'Inception', 'plot' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 'year' => 2010, 'rating' => 8.8],
            ['id' => 4, 'title' => '1917 ', 'plot' => ' As a regiment assembles to wage war deep in enemy territory, two soldiers are assigned to race against time and deliver a message that will stop 1,600 men from walking straight into a deadly trap.', 'year' => 2018, 'rating' => 8.4],
            ['id' => 5, 'title' => 'Alien', 'plot' => ' After a space merchant vessel receives an unknown transmission as a distress call, one of the team\'s member is attacked by a mysterious life form and they soon realize that its life cycle has merely begun.', 'year' => 1979, 'rating' => 8.4]
        ]);

        return $index;
    }


}
