<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\Persistence\Doctrine\Query\DoctrineLastStationStateByStationQuery;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;
use tests\Support\TestCase\DatabaseTestCase;

class DoctrineLastStationStateByStationQueryIntegrationTest extends DatabaseTestCase
{
    /** @var DoctrineLastStationStateByStationQuery */
    private $query;

    /** @test */
    public function it_can_find_all_last_station_states_by_station(): void
    {
        $stationId1 = Uuid::uuid4();
        /** @var Station $station1 */
        $station1 = $this->buildPersisted(StationBuilder::create()->withStationId($stationId1));

        $stationId2 = Uuid::uuid4();
        /** @var Station $station2 */
        $station2 = $this->buildPersisted(StationBuilder::create()->withStationId($stationId2));

        $statedAt = new DateTimeImmutableStringable('2018-08-20 16:35:20');
        $statusClosed = StationStateStatusBuilder::create()->withStatusClosed()->build();
        $statusOpened = StationStateStatusBuilder::create()->withStatusOpened()->build();

        $this->buildPersisted(
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('-5 minutes'))
                ->withStationAssigned($station1)
                ->withAvailableBikeNumber(2)
                ->withAvailableSlotNumber(28)
                ->withStatus($statusOpened),
            StationStateBuilder::create()
                ->withStatedAt($statedAt)
                ->withStationAssigned($station1)
                ->withAvailableBikeNumber(29)
                ->withAvailableSlotNumber(1)
                ->withStatus($statusClosed),
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('-2 minutes'))
                ->withStationAssigned($station2)
                ->withAvailableBikeNumber(10)
                ->withAvailableSlotNumber(10)
                ->withStatus($statusOpened),
            StationStateBuilder::create()
                ->withStatedAt($statedAt)
                ->withStationAssigned($station2)
                ->withAvailableBikeNumber(15)
                ->withAvailableSlotNumber(5)
                ->withStatus($statusOpened)
        );

        $this->assertEquals([
            [
                'station_id' => $stationId2->toString(),
                'stated_at' => $statedAt,
                'available_bike_number' => 15,
                'available_slot_number' => 5,
                'status' => $statusOpened,
            ],
            [
                'station_id' => $stationId1->toString(),
                'stated_at' => $statedAt,
                'available_bike_number' => 29,
                'available_slot_number' => 1,
                'status' => $statusClosed,
            ],
        ], $this->query->findAll());
    }

    /** @test */
    public function it_can_not_find_all_if_no_record_with_a_last_stated_at_found(): void
    {
        $this->assertEquals([], $this->query->findAll());
    }

    /** @test */
    public function it_can_find_last_station_sate_for_specific_station(): void
    {
        $stationId = Uuid::uuid4();
        /** @var Station $station */
        $station = $this->buildPersisted(StationBuilder::create()->withStationId($stationId));

        $statedAt = new DateTimeImmutableStringable('2018-07-20 07:55:30');
        $statusClosed = StationStateStatusBuilder::create()->withStatusClosed()->build();
        $statusOpened = StationStateStatusBuilder::create()->withStatusOpened()->build();

        $this->buildPersisted(
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('-5 minutes'))
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(2)
                ->withAvailableSlotNumber(28)
                ->withStatus($statusOpened),
            StationStateBuilder::create()
                ->withStatedAt($statedAt)
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(29)
                ->withAvailableSlotNumber(1)
                ->withStatus($statusClosed),
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('+2 minutes'))
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(10)
                ->withAvailableSlotNumber(10)
                ->withStatus($statusOpened)
        );

        $this->assertEquals([
            'station_id' => $stationId->toString(),
            'stated_at' => $statedAt->modify('+2 minutes'),
            'available_bike_number' => 10,
            'available_slot_number' => 10,
            'status' => $statusOpened,
        ], $this->query->find($stationId));
    }

    /** @test */
    public function it_can_not_find_last_station_sate_for_a_station_that_does_not_exist(): void
    {
        /** @var Station $station */
        $station = $this->buildPersisted(StationBuilder::create()->withStationId(Uuid::uuid4()));
        $this->buildPersisted(StationStateBuilder::create()->withStationAssigned($station));

        $this->assertNull($this->query->find(Uuid::uuid4()));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->query = $this->getContainer()->get('test.app.query.last_station_state_by_station_query');
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->query = null;

        parent::tearDown();
    }
}
