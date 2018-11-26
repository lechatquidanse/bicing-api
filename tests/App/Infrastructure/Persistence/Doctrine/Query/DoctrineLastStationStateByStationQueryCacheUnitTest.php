<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\Persistence\Doctrine\Cache\DoctrineLastStationStateByStationCache;
use App\Infrastructure\Persistence\Doctrine\Query\DoctrineLastStationStateByStationQueryCache;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\App\Infrastructure\Persistence\Doctrine\Cache\MockCache;
use tests\Support\Builder\StationStateStatusBuilder;

class DoctrineLastStationStateByStationQueryCacheUnitTest extends TestCase
{
    /** @var DoctrineLastStationStateByStationQueryCache */
    private $queryCache;

    /** @var MockLastStationStateByStationQuery */
    private $query;

    /** @var DoctrineLastStationStateByStationCache */
    private $cache;

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_find_all_from_source_and_set_in_cache(): void
    {
        $stationId1 = Uuid::uuid4();
        $stationId2 = Uuid::uuid4();
        $statusClosed = StationStateStatusBuilder::create()->withStatusClosed()->build();
        $statusOpened = StationStateStatusBuilder::create()->withStatusOpened()->build();
        $statedAt = new DateTimeImmutableStringable();

        $this->query->addStationSateWithData($stationId1, $statedAt, 23, 12, $statusClosed);
        $this->query->addStationSateWithData($stationId2, $statedAt, 19, 4, $statusOpened);

        $expected = [
            $stationId1->toString() => [
                'station_id' => $stationId1->toString(),
                'stated_at' => $statedAt,
                'available_bike_number' => 23,
                'available_slot_number' => 12,
                'status' => $statusClosed,
            ],
            $stationId2->toString() => [
                'station_id' => $stationId2->toString(),
                'stated_at' => $statedAt,
                'available_bike_number' => 19,
                'available_slot_number' => 4,
                'status' => $statusOpened,
            ],
        ];

        $this->assertFalse($this->cache->get());
        $this->assertEquals($expected, $this->queryCache->findAll());
        $this->assertEquals($expected, $this->cache->get());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_can_find_all_from_cache(): void
    {
        $expected = [
            [
                'station_id' => Uuid::uuid4()->toString(),
                'stated_at' => new DateTimeImmutableStringable(),
                'available_bike_number' => 23,
                'available_slot_number' => 12,
                'status' => StationStateStatusBuilder::create()->withStatusClosed()->build(),
            ],
            [
                'station_id' => Uuid::uuid4()->toString(),
                'stated_at' => new DateTimeImmutableStringable(),
                'available_bike_number' => 19,
                'available_slot_number' => 4,
                'status' => StationStateStatusBuilder::create()->withStatusOpened()->build(),
            ],
        ];

        $this->cache->set($expected);
        $this->assertEquals($expected, $this->queryCache->findAll());
    }

    /** @test */
    public function it_can_find_last_station_sate_for_specific_station(): void
    {
        $stationId = Uuid::uuid4();
        $statusClosed = StationStateStatusBuilder::create()->withStatusClosed()->build();
        $statedAt = new DateTimeImmutableStringable();

        $this->query->addStationSateWithData($stationId, $statedAt, 23, 12, $statusClosed);

        $this->assertEquals(
            [
                'station_id' => $stationId,
                'stated_at' => $statedAt,
                'available_bike_number' => 23,
                'available_slot_number' => 12,
                'status' => StationStateStatusBuilder::create()->withStatusClosed()->build(),
            ],
            $this->queryCache->find($stationId)
        );
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->query = new MockLastStationStateByStationQuery();
        $this->cache = new DoctrineLastStationStateByStationCache(
            new MockCache()
        );

        $this->queryCache = new DoctrineLastStationStateByStationQueryCache($this->query, $this->cache);
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->cache = null;
        $this->query = null;
        $this->queryCache = null;

        parent::tearDown();
    }
}
