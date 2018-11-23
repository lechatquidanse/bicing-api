<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use App\Domain\Model\UseCaseInterface;
use Ramsey\Uuid\UuidInterface;
use App\UserInterface\Rest\Controller\StationAvailabilitiesByIntervalInPeriodFilterController;

/**
 * @ApiResource(
 *     shortName="collection of availabilities by time interval filter for a station",
 *     itemOperations={
 *       "availabilities"={
 *         "method"="GET",
 *         "path"="/stations/{id}/availabilities",
 *         "controller"=StationAvailabilitiesByIntervalInPeriodFilterController::class,
 *         "defaults"={"_api_receive"=false}
 *        }
 *     },
 *     collectionOperations={}
 *  )
 */
final class StationAvailabilitiesByIntervalInPeriodFilterView implements UseCaseInterface
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(identifier=true)
     */
    public $stationId;

    /** @var array */
    public $availabilities;

    /** @var ByIntervalInPeriodFilter */
    public $filter;

    /**
     * StationAvailabilitiesByIntervalInPeriodView constructor.
     *
     * @param UuidInterface            $stationId
     * @param array                    $availabilities
     * @param ByIntervalInPeriodFilter $filter
     */
    public function __construct(UuidInterface $stationId, array $availabilities, ByIntervalInPeriodFilter $filter)
    {
        $this->stationId = $stationId;
        $this->availabilities = $availabilities;
        $this->filter = $filter;
    }
}
