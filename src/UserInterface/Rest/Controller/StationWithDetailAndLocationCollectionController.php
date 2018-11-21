<?php

declare(strict_types=1);

namespace App\UserInterface\Rest\Controller;

use App\Application\UseCase\DataProvider\StationWithDetailAndLocationCollectionDataProvider;
use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class StationWithDetailAndLocationCollectionController
{
    /** @var StationWithDetailAndLocationCollectionDataProvider */
    private $provider;

    /**
     * @param StationWithDetailAndLocationCollectionDataProvider $provider
     */
    public function __construct(StationWithDetailAndLocationCollectionDataProvider $provider)
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
     *     converter="by_geo_location_filter_param_converter"
     * )
     */
    public function __invoke(ByGeoLocationFilter $filter = null): \Generator
    {
        return $this->provider->getCollection($filter);
    }
}
