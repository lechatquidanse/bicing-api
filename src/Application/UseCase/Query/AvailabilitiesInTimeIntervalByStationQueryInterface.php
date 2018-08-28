<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use Ramsey\Uuid\UuidInterface;

interface AvailabilitiesInTimeIntervalByStationQueryInterface
{
    public function find(UuidInterface $stationId, DateTimeImmutableStringable $statedAt): array;
}
