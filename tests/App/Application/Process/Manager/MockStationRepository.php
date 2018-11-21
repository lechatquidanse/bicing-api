<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class MockStationRepository implements StationRepositoryInterface
{
    /** @var array */
    private $stations = [];

    public function add(Station $station): void
    {
        $this->stations[] = $station;
    }

    public function findByStationId(UuidInterface $stationId): ?Station
    {
        return null;
    }

    public function findByExternalStationId(string $externalStationId): ?Station
    {
        return null;
    }

    public function findAll(): array
    {
        return $this->stations;
    }
}
