<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use App\Application\UseCase\Filter\ByGeoLocationFilter;

interface StationsByGeoLocationFilterQueryInterface
{
    /**
     * @param ByGeoLocationFilter $filter
     *
     * @return array
     */
    public function findAll(ByGeoLocationFilter $filter): array;
}
