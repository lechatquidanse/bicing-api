<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\Station\StationDetailType;
use Ramsey\Uuid\UuidInterface;

/**
 * @todo add use immutbale
 */
final class CreateStationCommand
{
    /**
     * @var UuidInterface
     */
    public $stationId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var StationDetailType
     */
    public $type;

    /**
     * @var string
     */
    public $externalStationId;

    /**
     * @var array
     */
    public $nearByExternalStationIds;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $addressNumber;

    /**
     * @var int
     */
    public $districtCode;

    /**
     * @var string
     */
    public $zipCode;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var \DateTimeImmutable
     */
    public $createdAt;
}
