<?php

namespace ManticoreSearch\Laravel\Tests;

use Manticoresearch\Index;
use ManticoreSearch\Laravel\Factory;
use ManticoreSearch\Laravel\Manager;
use ManticoreSearch;
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
        $this->assertInstanceOf(Factory::class, $factory);

        $manager = app('manticoresearch');
        $this->assertInstanceOf(Manager::class, $manager);

        $client = app(Client::class);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFacadeConnection(): void
    {
        $connection = ManticoreSearch::connection('second');
        $this->assertInstanceOf(Index::class, $connection);

        $client = $connection->getClient();
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFacadeWorks(): void
    {
        $index = ManticoreSearch::index('test');
        $this->assertInstanceOf(Index::class, $index);
        $this->assertEquals('test', $index->getName());

//        $client = ManticoreSearch::client();
//        $this->assertInstanceOf(Client::class, $client);
    }

    public function testFacadeIndexHasMethods(): void
    {
        $index = ManticoreSearch::index('test');
        $this->assertEquals(get_class_methods($index), $this->index);
    }

//    public function testFacadeClientHasMethods(): void
//    {
//        $index = ManticoreSearch::client();
//        $this->assertEquals(get_class_methods($index), $this->client);
//    }
}
