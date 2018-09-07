<?php

declare(strict_types=1);

namespace tests\Support\Context;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;
use tests\Support\Service\DoctrineDatabaseManager;

class AvailabilitiesByStationContext implements Context
{
    /** @var DoctrineDatabaseManager */
    private $databaseManager;

    /**
     * @param DoctrineDatabaseManager $databaseManager
     */
    public function __construct(DoctrineDatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @Given station identified by :stationId with "station states from :dayStatedAt:
     */
    public function stationWithStationStatesFrom($stationId, $dayStatedAt, TableNode $stationStates): void
    {
        $statedAt = new DateTimeImmutableStringable($dayStatedAt);
        $status = StationStateStatusBuilder::create()->withStatusOpened()->build();

        /** @var Station $station */
        $station = $this->databaseManager->buildPersisted(StationBuilder::create()
            ->withStationId(Uuid::fromString($stationId)));

        foreach ($stationStates as $stationState) {
            $this->databaseManager->buildPersisted(StationStateBuilder::create()
                ->withAvailableBikeNumber((int) $stationState['available_bike'])
                ->withAvailableSlotNumber((int) $stationState['available_slot'])
                ->withStatedAt($statedAt->modify($stationState['stated_at']))
                ->withStationAssigned($station)
                ->withStatus($status));
        }
    }
}
