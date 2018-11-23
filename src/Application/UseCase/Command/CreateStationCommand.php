<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\Station\StationDetailType;
use App\Domain\Model\UseCaseInterface;
use Ramsey\Uuid\UuidInterface;

final class CreateStationCommand implements UseCaseInterface
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
