<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationStateStatus;
use Ramsey\Uuid\UuidInterface;

/**
 * @ApiResource(
 *     shortName="lastAvailabilitiesByStationView",
 *     routePrefix="/last-availabilities-by-station",
 *     collectionOperations={"get"={"method"="GET", "path"=""}},
 *     itemOperations={"get"={"method"="GET", "path"="/{id}"}}
 *  )
 */
final class LastStationStateByStationView
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(identifier=true)
     */
    public $id;

    /**
     * @var DateTimeImmutableStringable
     */
    public $statedAt;

    /**
     * @var int
     */
    public $availableBikeNumber;

    /**
     * @var int
     */
    public $availableSlotNumber;

    /**
     * @var string
     */
    public $status;

    /**
     * @param array $array
     *
     * @return LastStationStateByStationView
     */
    public static function fromArray(array $array): LastStationStateByStationView
    {
        $view = new self();

        $view->id = $array['station_id'] ?? null;
        $view->statedAt = $array['stated_at'] ?? null;
        $view->availableBikeNumber = $array['available_bike_number'] ?? null;
        $view->availableSlotNumber = $array['available_slot_number'] ?? null;
        $view->status = $array['status'] instanceof StationStateStatus ? $array['status']->__toString() : null;

        return $view;
    }
}
