<?php

declare(strict_types=1);

namespace Tests\App\Application\UseCase\Handler;

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
        $this->stations[$station->externalStationId()] = $station;
    }

    public function findByStationId(UuidInterface $stationId): ?Station
    {
        return null;
    }

    public function findByExternalStationId(string $externalStationId): ?Station
    {
        if (array_key_exists($externalStationId, $this->stations)) {
            return $this->stations[$externalStationId];
        }

        return null;
    }
}
