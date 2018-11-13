<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use App\Application\UseCase\Filter\IntervalInPeriodFilter;
use Ramsey\Uuid\UuidInterface;

interface StationAvailabilitiesByIntervalInPeriodQueryInterface
{
    public function find(UuidInterface $stationId, IntervalInPeriodFilter $filter): array;
}
