<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\Station\Location;

class LocationBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string|null
     */
    private $addressNumber;

    /**
     * @var int
     */
    private $districtCode;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /** @var string */
    private $geometry;

    /**
     * @param string      $address
     * @param string|null $addressNumber
     * @param int         $districtCode
     * @param string      $zipCode
     * @param float       $latitude
     * @param float       $longitude
     * @param string      $geometry
     */
    private function __construct(
        string $address,
        int $districtCode,
        string $zipCode,
        float $latitude,
        float $longitude,
        string $addressNumber = null,
        string $geometry = null
    ) {
        $this->address = $address;
        $this->addressNumber = $addressNumber;
        $this->districtCode = $districtCode;
        $this->zipCode = $zipCode;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->geometry = $geometry;
    }

    /**
     * {@inheritdoc}
     *
     * @return LocationBuilder
     */
    public static function create(): LocationBuilder
    {
        return new self(
            'Sant Pere Més Alt',
            1,
            '08003',
            41.387074,
            2.175247,
            null,
            null
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return Location
     *
     * @throws \Assert\AssertionFailedException
     */
    public function build(): Location
    {
        $location = Location::fromRawValues(
            $this->address,
            $this->districtCode,
            $this->zipCode,
            $this->latitude,
            $this->longitude
        );

        if (null !== $this->addressNumber) {
            $location->withAddressNumber($this->addressNumber);
        }

        if (null !== $this->geometry) {
            $location->withGeometry($this->geometry);
        }

        return $location;
    }

    /**
     * @param string $address
     *
     * @return LocationBuilder
     */
    public function withAddress(string $address): LocationBuilder
    {
        $copy = $this->copy();
        $copy->address = $address;

        return $copy;
    }

    /**
     * @param string|null $addressNumber
     *
     * @return LocationBuilder
     */
    public function withAddressNumber(string $addressNumber = null): LocationBuilder
    {
        $copy = $this->copy();
        $copy->addressNumber = $addressNumber;

        return $copy;
    }

    /**
     * @param int $districtCode
     *
     * @return LocationBuilder
     */
    public function withDistrictCode(int $districtCode): LocationBuilder
    {
        $copy = $this->copy();
        $copy->districtCode = $districtCode;

        return $copy;
    }

    /**
     * @param string $zipCode
     *
     * @return LocationBuilder
     */
    public function withZipCode(string $zipCode): LocationBuilder
    {
        $copy = $this->copy();
        $copy->zipCode = $zipCode;

        return $copy;
    }

    /**
     * @param float $latitude
     *
     * @return LocationBuilder
     */
    public function withLatitude(float $latitude): LocationBuilder
    {
        $copy = $this->copy();
        $copy->latitude = $latitude;

        return $copy;
    }

    /**
     * @param float $longitude
     *
     * @return LocationBuilder
     */
    public function withLongitude(float $longitude): LocationBuilder
    {
        $copy = $this->copy();
        $copy->longitude = $longitude;

        return $copy;
    }

    /**
     * @param string $geometry
     *
     * @return LocationBuilder
     */
    public function withGeometry(string $geometry = null): LocationBuilder
    {
        $copy = $this->copy();
        $copy->geometry = $geometry;

        return $copy;
    }

    /**
     * @return LocationBuilder
     */
    private function copy(): LocationBuilder
    {
        return new self(
            $this->address,
            $this->districtCode,
            $this->zipCode,
            $this->latitude,
            $this->longitude,
            $this->addressNumber,
            $this->geometry
        );
    }
}
