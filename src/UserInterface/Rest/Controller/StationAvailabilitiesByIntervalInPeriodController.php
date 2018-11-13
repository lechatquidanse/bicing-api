<?php

declare(strict_types=1);

namespace App\UserInterface\Rest\Controller;

use App\Application\UseCase\Filter\IntervalInPeriodFilter;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodQueryInterface;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodView;
use App\Domain\Model\Station\Station;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class StationAvailabilitiesByIntervalInPeriodController
{
    /** @var StationAvailabilitiesByIntervalInPeriodQueryInterface */
    private $query;

    /**
     * @param StationAvailabilitiesByIntervalInPeriodQueryInterface $query
     */
    public function __construct(StationAvailabilitiesByIntervalInPeriodQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @param Station                $station
     * @param IntervalInPeriodFilter $filter
     *
     * @return StationAvailabilitiesByIntervalInPeriodView
     *
     * @ParamConverter("station", class="App\Domain\Model\Station\Station", converter="station_param_converter")
     * @ParamConverter(
     *     "filter",
     *     class="App\Application\UseCase\Filter\IntervalInPeriodFilter",
     *     converter="interval_in_period_param_converter",
     *     options={
     *      "defaultPeriodStart"="last week -1 hour",
     *      "defaultPeriodEnd"="last week +1 hour",
     *      "defaultInterval"="5 minute",
     *     }
     * )
     */
    public function __invoke(
        Station $station,
        IntervalInPeriodFilter $filter
    ): StationAvailabilitiesByIntervalInPeriodView {
        return new StationAvailabilitiesByIntervalInPeriodView(
            $station->stationId(),
            $this->query->find($station->stationId(), $filter),
            $filter
        );
    }
}
