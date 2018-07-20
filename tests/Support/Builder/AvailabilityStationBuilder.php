<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Infrastructure\BicingApi\AvailabilityStation;

class AvailabilityStationBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $districtCode;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var int
     */
    private $bikes;

    /**
     * @var int
     */
    private $slots;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $addressNumber;

    /**
     * @var array
     */
    private $nearByStationIds;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $id
     * @param int    $districtCode
     * @param float  $longitude
     * @param float  $latitude
     * @param int    $bikes
     * @param int    $slots
     * @param string $zipCode
     * @param string $address
     * @param string $addressNumber
     * @param array  $nearByStationIds
     * @param string $status
     * @param string $name
     * @param string $type
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
        string $addressNumber,
        array $nearByStationIds,
        string $status,
        string $name,
        string $type)
    {
        $this->id               = $id;
        $this->districtCode     = $districtCode;
        $this->longitude        = $longitude;
        $this->latitude         = $latitude;
        $this->bikes            = $bikes;
        $this->slots            = $slots;
        $this->zipCode          = $zipCode;
        $this->address          = $address;
        $this->addressNumber    = $addressNumber;
        $this->nearByStationIds = $nearByStationIds;
        $this->status           = $status;
        $this->name             = $name;
        $this->type             = $type;
    }

    /**
     * {@inheritdoc}
     */
    public static function create()
    {
        return new self(
            '234',
            2,
            41.387074,
            2.175247,
            23,
            7,
            '08003',
            'Sant Pere Més Alt',
            '23',
            ['82', '232'],
            'OPN',
            'Sant Pere',
            'BIKE'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return AvailabilityStation
     */
    public function build(): AvailabilityStation
    {
        return AvailabilityStation::create(
            $this->id,
            $this->districtCode,
            $this->longitude,
            $this->latitude,
            $this->bikes,
            $this->slots,
            $this->zipCode,
            $this->address,
            $this->addressNumber,
            $this->nearByStationIds,
            $this->status,
            $this->name,
            $this->type
        );
    }

    /**
     * @param string $id
     *
     * @return AvailabilityStationBuilder
     */
    public function withId(string $id): AvailabilityStationBuilder
    {
        $copy     = $this->copy();
        $copy->id = $id;

        return $copy;
    }

    /**
     * @param int $bikes
     *
     * @return AvailabilityStationBuilder
     */
    public function withBikes(int $bikes): AvailabilityStationBuilder
    {
        $copy        = $this->copy();
        $copy->bikes = $bikes;

        return $copy;
    }

    /**
     * @param int $slots
     *
     * @return AvailabilityStationBuilder
     */
    public function withSlots(int $slots): AvailabilityStationBuilder
    {
        $copy        = $this->copy();
        $copy->slots = $slots;

        return $copy;
    }

    /**
     * @param string $status
     *
     * @return AvailabilityStationBuilder
     */
    public function withStatus(string $status): AvailabilityStationBuilder
    {
        $copy         = $this->copy();
        $copy->status = $status;

        return $copy;
    }

    /**
     * @param string $name
     *
     * @return AvailabilityStationBuilder
     */
    public function withName(string $name): AvailabilityStationBuilder
    {
        $copy       = $this->copy();
        $copy->name = $name;

        return $copy;
    }

    /**
     * @param string $type
     *
     * @return AvailabilityStationBuilder
     */
    public function withType(string $type): AvailabilityStationBuilder
    {
        $copy       = $this->copy();
        $copy->type = $type;

        return $copy;
    }

    /**
     * @param array $nearByStationIds
     *
     * @return AvailabilityStationBuilder
     */
    public function withNearByStationIds(array $nearByStationIds): AvailabilityStationBuilder
    {
        $copy                   = $this->copy();
        $copy->nearByStationIds = $nearByStationIds;

        return $copy;
    }

    /**
     * @param string $address
     *
     * @return AvailabilityStationBuilder
     */
    public function withAddress(string $address): AvailabilityStationBuilder
    {
        $copy          = $this->copy();
        $copy->address = $address;

        return $copy;
    }

    /**
     * @param string $addressNumber
     *
     * @return AvailabilityStationBuilder
     */
    public function withAddressNumber(string $addressNumber): AvailabilityStationBuilder
    {
        $copy                = $this->copy();
        $copy->addressNumber = $addressNumber;

        return $copy;
    }

    /**
     * @param int $districtCode
     *
     * @return AvailabilityStationBuilder
     */
    public function withDistrictCode(int $districtCode): AvailabilityStationBuilder
    {
        $copy               = $this->copy();
        $copy->districtCode = $districtCode;

        return $copy;
    }

    /**
     * @param string $zipCode
     *
     * @return AvailabilityStationBuilder
     */
    public function withZipCode(string $zipCode): AvailabilityStationBuilder
    {
        $copy          = $this->copy();
        $copy->zipCode = $zipCode;

        return $copy;
    }

    /**
     * @param float $latitude
     *
     * @return AvailabilityStationBuilder
     */
    public function withLatitude(float $latitude): AvailabilityStationBuilder
    {
        $copy           = $this->copy();
        $copy->latitude = $latitude;

        return $copy;
    }

    /**
     * @param float $longitude
     *
     * @return AvailabilityStationBuilder
     */
    public function withLongitude(float $longitude): AvailabilityStationBuilder
    {
        $copy            = $this->copy();
        $copy->longitude = $longitude;

        return $copy;
    }

    /**
     * @return AvailabilityStationBuilder
     */
    private function copy(): AvailabilityStationBuilder
    {
        return new self(
            $this->id,
            $this->districtCode,
            $this->longitude,
            $this->latitude,
            $this->bikes,
            $this->slots,
            $this->zipCode,
            $this->address,
            $this->addressNumber,
            $this->nearByStationIds,
            $this->status,
            $this->name,
            $this->type
        );
    }
}
