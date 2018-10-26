<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Domain\Model\UseCase;
use Ramsey\Uuid\UuidInterface;

/**
 * @ApiResource(
 *     shortName="collection of availabilities in a period for a station",
 *     itemOperations={
 *     "get"={"method"="GET", "path"="/availabilities/{id}"}},
 *     collectionOperations={}
 *     )
 */
final class AvailabilitiesInTimeIntervalByStationView implements UseCase
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
