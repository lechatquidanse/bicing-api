<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use Ramsey\Uuid\UuidInterface;

interface AvailabilitiesInTimeIntervalByStationQueryInterface
{
    public function find(UuidInterface $stationId): AvailabilitiesInTimeIntervalByStationView;
}
