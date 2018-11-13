<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class MockStationRepository implements StationRepositoryInterface
{
    /**
     * @var array
     */
    private $stations = [];

    public function add(Station $station): void
    {
        $this->stations[$station->stationId()->toString()] = $station;
    }

    public function findByStationId(UuidInterface $stationId): ?Station
    {
        if (array_key_exists($stationId->toString(), $this->stations)) {
            return $this->stations[$stationId->toString()];
        }

        return null;
    }

    public function findByExternalStationId(string $externalStationId): ?Station
    {
        return null;
    }
}
