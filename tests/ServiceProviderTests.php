<?php

namespace Tests\ManticoreSearch\Laravel;

use Manticoresearch\Endpoints\Pq;
use Manticoresearch\Index;
use ManticoreSearch\Laravel\Factory;
use ManticoreSearch\Laravel\Manager;
use Manticoresearch\Client;

class ServiceProviderTests extends TestCase
{
    /**
     * List of all methods which should be available in Index class of Manticore library
     *
     * @var string[]
     */
    private $index = [
        '__construct',
        'search',
        'getDocumentById',
        'getDocumentByIds',
        'addDocument',
        'addDocuments',
        'deleteDocument',
        'deleteDocuments',
        'updateDocument',
        'updateDocuments',
        'replaceDocument',
        'replaceDocuments',
        'create',
        'drop',
        'describe',
        'status',
        'truncate',
        'optimize',
        'flush',
        'flushramchunk',
        'alter',
        'keywords',
        'suggest',
        'explainQuery',
        'percolate',
        'percolateToDocs',
        'getClient',
        'getName',
        'setName',
        'setCluster',
    ];

    private $client = [
        '__construct',
        'setHosts',
        'setConfig',
        'create',
        'createFromArray',
        'getConnections',
        'getConnectionPool',
        'search',
        'insert',
        'replace',
        'update',
        'sql',
        'delete',
        'pq',
        'indices',
        'nodes',
        'cluster',
        'index',
        'bulk',
        'suggest',
        'keywords',
        'explainQuery',
        'request',
        'getLastResponse',
    ];

    public function testAbstractsAreLoaded(): void
    {
        $factory = app('manticoresearch.factory');
        self::assertInstanceOf(Factory::class, $factory);

        $manager = app('manticoresearch');
        self::assertInstanceOf(Manager::class, $manager);

        $client = app(Client::class);
        self::assertInstanceOf(Client::class, $client);
    }

    public function testFacadeConnection(): void
    {
        // Check default
        $connectionName = \ManticoreSearch::getDefaultConnection();
        self::assertEquals('default', $connectionName);

        // Check updated
        $connection = \ManticoreSearch::connection('second');
        self::assertInstanceOf(Client::class, $connection);
        $connectionName = \ManticoreSearch::getDefaultConnection();
        self::assertEquals('default', $connectionName);

        // Check setter
        \ManticoreSearch::setDefaultConnection('third');
        $connectionName = \ManticoreSearch::getDefaultConnection();
        self::assertEquals('third', $connectionName);
    }

    public function testFacadeGetConnections(): void
    {
        $count = \ManticoreSearch::getConnections();
        self::assertEmpty($count);

        \ManticoreSearch::connection('default');
        \ManticoreSearch::connection('second');

        $count = \ManticoreSearch::getConnections();
        self::assertCount(2, $count);
    }

    public function testFacadeConnectionException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        \ManticoreSearch::connection('third');
    }

    public function testFacadeWorks(): void
    {
        $client = \ManticoreSearch::client();
        self::assertInstanceOf(Client::class, $client);

        $index = \ManticoreSearch::index('test');
        self::assertInstanceOf(Index::class, $index);
        self::assertEquals('test', $index->getName());

        $pq = \ManticoreSearch::pq();
        self::assertInstanceOf(Pq::class, $pq);
    }

    public function testFacadeIndexHasMethods(): void
    {
        $index = \ManticoreSearch::index('test');
        self::assertEquals(get_class_methods($index), $this->index);
    }

    public function testFacadeClientHasMethods(): void
    {
        $index = \ManticoreSearch::client();
        self::assertEquals(get_class_methods($index), $this->client);
    }
}
