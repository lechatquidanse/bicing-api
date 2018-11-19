<?php

declare(strict_types=1);

namespace tests\Support\Context;

use App\Application\Process\Manager\UpdateStationsLocationGeometryManager;
use App\Domain\Model\Station\StationDetailType;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\LocationBuilder;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationDetailBuilder;
use tests\Support\Service\DoctrineDatabaseManager;

class StationWithDetailAndLocationContext implements Context
{
    /** @var DoctrineDatabaseManager */
    private $databaseManager;

    /** @var UpdateStationsLocationGeometryManager */
    private $geometryManager;

    /**
     * StationWithDetailAndLocationContext constructor.
     *
     * @param DoctrineDatabaseManager               $databaseManager
     * @param UpdateStationsLocationGeometryManager $geometryManager
     */
    public function __construct(DoctrineDatabaseManager $databaseManager, UpdateStationsLocationGeometryManager $geometryManager)
    {
        $this->databaseManager = $databaseManager;
        $this->geometryManager = $geometryManager;
    }

    /**
     * @Given a list of station:
     */
    public function aListOfStation(TableNode $stations): void
    {
        foreach ($stations as $station) {
            $this->databaseManager->buildPersisted(StationBuilder::create()
                ->withStationId(Uuid::fromString($station['stationId']))
                ->withStationDetail(StationDetailBuilder::create()
                    ->withName($station['name'])
                    ->withType(StationDetailType::fromString($station['type']))
                    ->build())
                ->withLocation(LocationBuilder::create()
                    ->withAddress($station['address'])
                    ->withAddressNumber($station['addressNumber'])
                    ->withZipCode($station['zipCode'])
                    ->withLatitude((float) $station['latitude'])
                    ->withLongitude((float) $station['longitude'])
                    ->build()));
        }

        $this->geometryManager->__invoke();
    }
}
