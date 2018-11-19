<?php

declare(strict_types=1);

namespace App\UserInterface\Rest\Controller;

use App\Application\UseCase\DataProvider\StationWithDetailAndLocationByGeoLocationDataProvider;
use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class StationByGeoLocationFilterController
{
    /** @var StationWithDetailAndLocationByGeoLocationDataProvider */
    private $provider;

    /**
     * @param StationWithDetailAndLocationByGeoLocationDataProvider $provider
     */
    public function __construct(StationWithDetailAndLocationByGeoLocationDataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param ByGeoLocationFilter $filter
     *
     * @return \Generator
     *
     * @ParamConverter(
     *     "filter",
     *     class="App\Application\UseCase\Filter\ByGeoLocationFilter",
     *     converter="by_geo_location_filter_param_converter",
     *     options={
     *      "defaultLatitude"=41.390205,
     *      "defaultLongitude"=2.154007,
     *      "defaultLimit"=500.00,
     *     }
     * )
     */
    public function __invoke(ByGeoLocationFilter $filter): \Generator
    {
        return $this->provider->getCollection($filter);
    }
}
