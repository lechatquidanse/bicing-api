<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;

class StationWithDetailAndLocationCollectionDataProvider
{
    /** @var StationWithDetailAndLocationQueryInterface */
    private $query;

    /**
     * @param StationWithDetailAndLocationQueryInterface $query
     */
    public function __construct(StationWithDetailAndLocationQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @param ByGeoLocationFilter $filter
     *
     * @return \Generator
     */
    public function getCollection(ByGeoLocationFilter $filter = null): \Generator
    {
        $stations = $this->query->findAll($filter);

        foreach ($stations as $station) {
            yield StationWithDetailAndLocationView::fromArray($station);
        }
    }
}
