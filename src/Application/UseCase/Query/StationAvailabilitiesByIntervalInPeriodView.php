<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCase\Filter\IntervalInPeriodFilter;
use App\Domain\Model\UseCase;
use Ramsey\Uuid\UuidInterface;
use App\UserInterface\Rest\Controller\StationAvailabilitiesByIntervalInPeriodController;

/**
 * @ApiResource(
 *     shortName="collection of availabilities by time interval for a station",
 *     itemOperations={
 *       "availabilities"={
 *         "method"="GET",
 *         "path"="/stations/{id}/availabilities",
 *         "controller"=StationAvailabilitiesByIntervalInPeriodController::class,
 *         "defaults"={"_api_receive"=false}
 *        }
 *     },
 *     collectionOperations={}
 *  )
 */
final class StationAvailabilitiesByIntervalInPeriodView implements UseCase
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(identifier=true)
     */
    public $stationId;

    /** @var array */
    public $availabilities;

    /** @var IntervalInPeriodFilter */
    public $filter;

    /**
     * StationAvailabilitiesByIntervalInPeriodView constructor.
     *
     * @param UuidInterface          $stationId
     * @param array                  $availabilities
     * @param IntervalInPeriodFilter $filter
     */
    public function __construct(UuidInterface $stationId, array $availabilities, IntervalInPeriodFilter $filter)
    {
        $this->stationId = $stationId;
        $this->availabilities = $availabilities;
        $this->filter = $filter;
    }
}
