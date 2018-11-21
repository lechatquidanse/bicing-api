<?php

declare(strict_types=1);

namespace App\UserInterface\Rest\Controller;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodFilterQueryInterface;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodFilterView;
use App\Domain\Model\Station\Station;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class StationAvailabilitiesByIntervalInPeriodFilterController
{
    /** @var StationAvailabilitiesByIntervalInPeriodFilterQueryInterface */
    private $query;

    /**
     * @param StationAvailabilitiesByIntervalInPeriodFilterQueryInterface $query
     */
    public function __construct(StationAvailabilitiesByIntervalInPeriodFilterQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @param Station                  $station
     * @param ByIntervalInPeriodFilter $filter
     *
     * @return StationAvailabilitiesByIntervalInPeriodFilterView
     *
     * @ParamConverter("station", class="App\Domain\Model\Station\Station", converter="station_param_converter")
     * @ParamConverter(
     *     "filter",
     *     class="App\Application\UseCase\Filter\ByIntervalInPeriodFilter",
     *     converter="by_interval_in_period_filter_param_converter",
     *     options={
     *      "defaultPeriodStart"="last week -1 hour",
     *      "defaultPeriodEnd"="last week +1 hour",
     *      "defaultInterval"="5 minute",
     *     }
     * )
     */
    public function __invoke(
        Station $station,
        ByIntervalInPeriodFilter $filter
    ): StationAvailabilitiesByIntervalInPeriodFilterView {
        return new StationAvailabilitiesByIntervalInPeriodFilterView(
            $station->stationId(),
            $this->query->find($station->stationId(), $filter),
            $filter
        );
    }
}
