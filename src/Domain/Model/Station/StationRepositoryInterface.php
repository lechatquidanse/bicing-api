<?php

namespace App\Domain\Model\Station;

use Ramsey\Uuid\UuidInterface;

interface StationRepositoryInterface
{
    public function add(Station $station): void;

    public function findByStationId(UuidInterface $stationId): ?Station;

    public function findByExternalStationId(string $externalStationId): ?Station;
}
