<?php

namespace ManticoreSearch\Laravel\Tests;

use ManticoreSearch\Laravel\Factory;
use ManticoreSearch\Laravel\Manager;
use ManticoreSearch;
use Manticoresearch\Index;

class ServiceProviderTests extends TestCase
{
    public function testAbstractsAreLoaded(): void
    {
        $factory = app('manticoresearch.factory');
        $this->assertInstanceOf(Factory::class, $factory);

        $manager = app('manticoresearch');
        $this->assertInstanceOf(Manager::class, $manager);

        $client = app(Index::class);
        $this->assertInstanceOf(Index::class, $client);
    }

    public function testFacadeWorks(): void
    {
        $index = ManticoreSearch::index('test');
        $this->assertEquals('test', $index->getName());
    }
}
