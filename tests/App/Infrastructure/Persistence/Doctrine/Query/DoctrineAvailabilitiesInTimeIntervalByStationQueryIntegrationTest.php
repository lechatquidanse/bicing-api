<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\Persistence\Doctrine\Query\DoctrineAvailabilitiesInTimeIntervalByStationQuery;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;
use tests\Support\TestCase\DatabaseTestCase;

class DoctrineAvailabilitiesInTimeIntervalByStationQueryIntegrationTest extends DatabaseTestCase
{
    /** @var DoctrineAvailabilitiesInTimeIntervalByStationQuery */
    private $query;

    /** @test */
    public function it_can_find_availabilities_with_opened_station_state_status_assigned_to_a_station(): void
    {
        $stationId = Uuid::uuid4();
        $statedAt = new DateTimeImmutableStringable('2018-08-20 16:35:20');
        $status = StationStateStatusBuilder::create()->withStatusOpened()->build();

        /** @var Station $station */
        $station = $this->buildPersisted(StationBuilder::create()->withStationId($stationId));

        $this->buildPersisted(
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('-55 minutes 1 seconds'))
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(7)
                ->withAvailableSlotNumber(23)
                ->withStatus($status),
            StationStateBuilder::create()
                ->withStatedAt($statedAt->modify('-55 minutes'))
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(2)
                ->withAvailableSlotNumber(28)
                ->withStatus($status),
            StationStateBuilder::create()
                ->withStatedAt($statedAt)
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(29)
                ->withAvailableSlotNumber(1)
                ->withStatus($status));

        $this->assertEquals([
            [
                'interval' => '2018-08-20 15:40:00',
                'available_bike_avg' => '4.5000000000000000',
                'available_bike_min' => 2,
                'available_bike_max' => 7,
                'available_slot_avg' => '25.5000000000000000',
                'available_slot_min' => 23,
                'available_slot_max' => 28,

            ],
            [
                'interval' => '2018-08-20 16:35:00',
                'available_bike_avg' => '29.0000000000000000',
                'available_bike_min' => 29,
                'available_bike_max' => 29,
                'available_slot_avg' => '1.0000000000000000',
                'available_slot_min' => 1,
                'available_slot_max' => 1,

            ],
        ], $this->query->find($stationId, $statedAt));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->query = $this->getContainer()->get('test.app.query.availabilites_in_time_interval_by_station_query');
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->query = null;

        parent::tearDown();
    }
}
