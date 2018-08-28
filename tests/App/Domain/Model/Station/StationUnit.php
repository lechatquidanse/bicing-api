<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\Station;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\LocationBuilder;
use tests\Support\Builder\StationDetailBuilder;
use tests\Support\Builder\StationExternalDataBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;

class StationUnit extends TestCase
{
    /**
     * Test that a Station State can be created and assigned threw Station.
     *
     * @test
     */
    public function it_can_assign_a_station_state()
    {
        $station = Station::create(
            Uuid::uuid4(),
            StationDetailBuilder::create()->build(),
            StationExternalDataBuilder::create()->build(),
            LocationBuilder::create()->build(),
            new \DateTimeImmutable()
        );

        $statedAt = new DateTimeImmutableStringable();
        $createdAt = new \DateTimeImmutable();
        $status = StationStateStatusBuilder::create()->withStatusOpened()->build();

        $this->assertEquals(
            StationStateBuilder::create()
                ->withStatedAt($statedAt)
                ->withStationAssigned($station)
                ->withAvailableBikeNumber(23)
                ->withAvailableSlotNumber(12)
                ->withCreatedAt($createdAt)
                ->withStatus($status)
                ->build(),
            $station->assignStationState(
                $statedAt,
                23,
                12,
                $status,
                $createdAt
            ));
    }
}
