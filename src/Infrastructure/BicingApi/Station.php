<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use App\Domain\Model\Station\StationDetailType;
use JMS\Serializer\Annotation as Serializer;

final class Station
{
    /** @var array */
    private const TYPE_FORMATTER = [
        'BIKE' => StationDetailType::TYPE_BIKE,
        'BIKE-ELECTRIC' => StationDetailType::TYPE_BIKE_ELECTRIC,
    ];

    /**
     * @Serializer\SerializedName("streetName")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @Serializer\Accessor(setter="typeToDomainType")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $type;

    /**
     * @Serializer\Accessor(setter="nearByStationsToArray")
     * @Serializer\SerializedName("nearbyStations")
     * @Serializer\Type("string")
     *
     * @var array|null
     */
    private $nearByStationIds;

    /**
     * @param string     $name
     * @param string     $type
     * @param array|null $nearByStationIds
     */
    private function __construct(string $name, string $type, ?array $nearByStationIds)
    {
        $this->name = $name;
        $this->type = $type;
        $this->nearByStationIds = $nearByStationIds;
    }

    /**
     * @param string     $name
     * @param string     $type
     * @param array|null $nearByStationIds
     *
     * @return Station
     */
    public static function fromRawValues(string $name, string $type, ?array $nearByStationIds): Station
    {
        return new self($name, $type, $nearByStationIds);
    }

    /**
     * @param string $type
     */
    public function typeToDomainType(string $type): void
    {
        if (isset(self::TYPE_FORMATTER[$type])) {
            $this->type = self::TYPE_FORMATTER[$type];
        }
    }

    /**
     * @param string|null $nearByStations
     */
    public function nearByStationsToArray(?string $nearByStations): void
    {
        if (null !== $nearByStations) {
            $this->nearByStationIds = explode(',', $nearByStations);
        }
    }

    /**
     * @return array|null
     */
    public function nearByStationIds(): ?array
    {
        return $this->nearByStationIds;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }
}
