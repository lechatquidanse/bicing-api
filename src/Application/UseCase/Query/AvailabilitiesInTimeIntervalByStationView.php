<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\UuidInterface;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={}
 *     )
 */
final class AvailabilitiesInTimeIntervalByStationView
{
    /**
     * @ApiProperty(identifier=true)
     *
     * @var UuidInterface
     */
    public $stationId;

    /** @var array */
    public $availabilities;

    /**
     * @param UuidInterface $stationId
     * @param array         $availabilities
     */
    public function __construct(UuidInterface $stationId, array $availabilities)
    {
        $this->stationId = $stationId;
        $this->availabilities = $availabilities;
    }
}
