<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use Ramsey\Uuid\UuidInterface;

interface StationAvailabilitiesByIntervalInPeriodFilterQueryInterface
{
    public function find(UuidInterface $stationId, ByIntervalInPeriodFilter $filter): array;
}
