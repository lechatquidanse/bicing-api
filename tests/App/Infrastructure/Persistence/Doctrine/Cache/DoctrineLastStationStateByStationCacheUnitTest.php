<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Factory\Form\DataTransformer;

use App\Infrastructure\Persistence\Doctrine\Cache\DoctrineLastStationStateByStationCache;
use PHPUnit\Framework\TestCase;
use tests\App\Infrastructure\Persistence\Doctrine\Cache\MockCache;

class DoctrineLastStationStateByStationCacheUnitTest extends TestCase
{
    /** @var DoctrineLastStationStateByStationCache */
    private $cache;

    /** @test */
    public function it_can_set_an_array_of_last_station_state_by_station_in_cache(): void
    {
        $lastStationStateByStation = ['value_station_state_1', 'value_station_state_2'];

        $this->cache->set($lastStationStateByStation);

        $this->assertEquals($lastStationStateByStation, $this->cache->get());
    }

    /** @test */
    public function it_can_overwrite_an_array_of_last_station_state_by_station_in_cache(): void
    {
        $lastStationStateByStation = ['new_value_station_state_1', 'new_value_station_state_2'];

        $this->cache->set(['value_station_state_1', 'value_station_state_2']);
        $this->cache->set($lastStationStateByStation);

        $this->assertEquals($lastStationStateByStation, $this->cache->get());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->cache = new DoctrineLastStationStateByStationCache(new MockCache());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->cache = null;

        parent::tearDown();
    }
}
