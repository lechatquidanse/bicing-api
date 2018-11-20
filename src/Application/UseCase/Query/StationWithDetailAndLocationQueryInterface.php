<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Ramsey\Uuid\UuidInterface;

interface StationWithDetailAndLocationQueryInterface
{
    /**
     * @param UuidInterface $stationId
     *
     * @return array[]
     */
    public function find(UuidInterface $stationId): ?array;

    /**
     * @param ByGeoLocationFilter|null $filter
     *
     * @return array
     */
    public function findAll(ByGeoLocationFilter $filter = null): array;
}
