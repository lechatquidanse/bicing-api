<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use JMS\Serializer\Annotation as Serializer;

final class AvailabilityStation
{
    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $id;

    /**
     * @Serializer\SerializedName("district")
     * @Serializer\Type("int")
     *
     * @var int
     */
    private $districtCode;

    /**
     * @Serializer\SerializedName("lon")
     * @Serializer\Type("float")
     *
     * @var float
     */
    private $longitude;

    /**
     * @Serializer\SerializedName("lat")
     * @Serializer\Type("float")
     *
     * @var float
     */
    private $latitude;

    /**
     * @Serializer\Type("int")
     *
     * @var int
     */
    private $bikes;

    /**
     * @Serializer\Type("int")
     *
     * @var int
     */
    private $slots;

    /**
     * @Serializer\SerializedName("zip")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $zipCode;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $address;

    /**
     * @Serializer\SerializedName("addressNumber")
     * @Serializer\Type("string")
     *
     * @var string|null
     */
    private $addressNumber;

    /**
     * @Serializer\Accessor(setter="nearByStationsToArray")
     * @Serializer\SerializedName("nearbyStations")
     * @Serializer\Type("string")
     *
     * @var array
     */
    private $nearByStationIds;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $status;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @Serializer\SerializedName("stationType")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $type;

    /**
     * @param string      $id
     * @param int         $districtCode
     * @param float       $longitude
     * @param float       $latitude
     * @param int         $bikes
     * @param int         $slots
     * @param string      $zipCode
     * @param string      $address
     * @param string|null $addressNumber
     * @param array       $nearByStationIds
     * @param string      $status
     * @param string      $name
     * @param string      $type
     */
    private function __construct(
        string $id,
        int $districtCode,
        float $longitude,
        float $latitude,
        int $bikes,
        int $slots,
        string $zipCode,
        string $address,
        string $addressNumber = null,
        array $nearByStationIds,
        string $status,
        string $name,
        string $type)
    {
        $this->id = $id;
        $this->districtCode = $districtCode;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->bikes = $bikes;
        $this->slots = $slots;
        $this->zipCode = $zipCode;
        $this->address = $address;
        $this->addressNumber = $addressNumber;
        $this->nearByStationIds = $nearByStationIds;
        $this->status = $status;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param string      $id
     * @param int         $districtCode
     * @param float       $longitude
     * @param float       $latitude
     * @param int         $bikes
     * @param int         $slots
     * @param string      $zipCode
     * @param string      $address
     * @param string|null $addressNumber
     * @param array       $nearByStationIds
     * @param string      $status
     * @param string      $name
     * @param string      $type
     *
     * @return self
     */
    public static function create(
        string $id,
        int $districtCode,
        float $longitude,
        float $latitude,
        int $bikes,
        int $slots,
        string $zipCode,
        string $address,
        string $addressNumber = null,
        array $nearByStationIds,
        string $status,
        string $name,
        string $type): self
    {
        return new self(
            $id,
            $districtCode,
            $longitude,
            $latitude,
            $bikes,
            $slots,
            $zipCode,
            $address,
            $addressNumber,
            $nearByStationIds,
            $status,
            $name,
            $type
        );
    }

    /**
     * @param string $nearByStations
     */
    public function nearByStationsToArray(string $nearByStations): void
    {
        $this->nearByStationIds = explode(',', $nearByStations);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function districtCode(): int
    {
        return $this->districtCode;
    }

    /**
     * @return float
     */
    public function longitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function latitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return int
     */
    public function bikes(): int
    {
        return $this->bikes;
    }

    /**
     * @return int
     */
    public function slots(): int
    {
        return $this->slots;
    }

    /**
     * @return string
     */
    public function zipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function addressNumber()
    {
        return $this->addressNumber;
    }

    /**
     * @return array
     */
    public function nearByStationIds(): array
    {
        return $this->nearByStationIds;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
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

    /**
     * @return string
     */
    public function statedAt(): string
    {
        return $this->statedAt;
    }
}
