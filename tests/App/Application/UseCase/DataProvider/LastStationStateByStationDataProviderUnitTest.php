<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\DataProvider;

use App\Application\UseCase\DataProvider\LastStationStateByStationDataProvider;
use App\Application\UseCase\Query\LastStationStateByStationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\App\Infrastructure\Persistence\Doctrine\Query\MockLastStationStateByStationQuery;
use tests\Support\Builder\StationStateStatusBuilder;

class LastStationStateByStationDataProviderUnitTest extends TestCase
{
    /** @var LastStationStateByStationDataProvider */
    private $provider;

    /** @var MockLastStationStateByStationQuery */
    private $query;

    /** @test */
    public function it_can_get_an_item_that_does_exist(): void
    {
        $stationId = Uuid::uuid4();
        $statedAt = new DateTimeImmutableStringable('2017-03-21 12:45:09');
        $status = StationStateStatusBuilder::create()->withStatusOpened()->build();

        $this->query->addStationSateWithData(
            $stationId,
            $statedAt,
            40,
            12,
            $status
        );

        $this->assertEquals(LastStationStateByStationView::fromArray([
            'station_id' => $stationId,
            'stated_at' => $statedAt,
            'available_bike_number' => 40,
            'available_slot_number' => 12,
            'status' => $status,
        ]), $this->provider->getItem(LastStationStateByStationView  ::class, $stationId));
    }

    /** @test */
    public function it_can_not_get_an_item_for_a_station_that_does_not_exist(): void
    {
        $this->expectException(StationDoesNotExist::class);
        $this->expectExceptionMessage(
            'A station does not exist with external station Id "50ca0f4c-a474-40e3-a1d0-8fd0901b46d3".'
        );

        $this->query->addStationSateWithData(
            Uuid::uuid4(),
            new DateTimeImmutableStringable('2017-03-21 12:45:09'),
            40,
            12,
            StationStateStatusBuilder::create()->withStatusOpened()->build()
        );

        $this->provider->getItem(
            LastStationStateByStationView::class,
            Uuid::fromString('50ca0f4c-a474-40e3-a1d0-8fd0901b46d3')
        );
    }

    /** @test */
    public function it_can_get_a_collection_that_exists(): void
    {
        $stationId1 = Uuid::uuid4();
        $stationId2 = Uuid::uuid4();
        $statedAt = new DateTimeImmutableStringable('2017-03-21 12:45:09');
        $statusOpened = StationStateStatusBuilder::create()->withStatusOpened()->build();
        $statusClosed = StationStateStatusBuilder::create()->withStatusClosed()->build();

        $this->query->addStationSateWithData(
            $stationId1,
            $statedAt,
            40,
            12,
            $statusOpened
        );

        $this->query->addStationSateWithData(
            $stationId2,
            $statedAt,
            32,
            87,
            $statusClosed
        );

        $generators = $this->provider->getCollection(LastStationStateByStationView::class);

        $this->assertEquals(
            LastStationStateByStationView::fromArray([
                'station_id' => $stationId1,
                'stated_at' => $statedAt,
                'available_bike_number' => 40,
                'available_slot_number' => 12,
                'status' => $statusOpened,
            ]),
            $generators->current()
        );

        $generators->next();

        $this->assertEquals(
            LastStationStateByStationView::fromArray([
                'station_id' => $stationId2,
                'stated_at' => $statedAt,
                'available_bike_number' => 32,
                'available_slot_number' => 87,
                'status' => $statusClosed,
            ]),
            $generators->current()
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->query = new MockLastStationStateByStationQuery();
        $this->provider = new LastStationStateByStationDataProvider($this->query);
    }

    protected function tearDown()
    {
        $this->provider = null;
        $this->query = null;

        parent::tearDown();
    }
}
