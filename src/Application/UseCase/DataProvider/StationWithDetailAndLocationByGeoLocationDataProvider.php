<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use App\Application\UseCase\Query\StationWithDetailAndLocationByGeoLocationFilterQueryInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;

class StationWithDetailAndLocationByGeoLocationDataProvider
{
    /** @var StationWithDetailAndLocationByGeoLocationFilterQueryInterface */
    private $query;

    /**
     * @param StationWithDetailAndLocationByGeoLocationFilterQueryInterface $query
     */
    public function __construct(StationWithDetailAndLocationByGeoLocationFilterQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @param ByGeoLocationFilter $filter
     * @return \Generator
     */
    public function getCollection(ByGeoLocationFilter $filter): \Generator
    {
        $stations = $this->query->findAll($filter);

        foreach ($stations as $station) {
            yield StationWithDetailAndLocationView::fromArray($station);
        }
    }
}
