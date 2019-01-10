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
     * @var int|null
     */
    private $districtCode;

    /**
     * @var string|null
     */
    private $zipCode;

    /**
     * @param string      $address
     * @param float       $latitude
     * @param float       $longitude
     * @param int|null    $districtCode
     * @param null|string $zipCode
     * @param null|string $addressNumber
     * @param null|string $geometry
     */
    private function __construct(
        string $address,
        float $latitude,
        float $longitude,
        ?string $addressNumber,
        ?int $districtCode,
        ?string $zipCode,
        ?string $geometry = null
    ) {
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->addressNumber = $addressNumber;
        $this->districtCode = $districtCode;
        $this->zipCode = $zipCode;
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
            41.387074,
            2.175247,
            null,
            null,
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
            $this->latitude,
            $this->longitude,
            $this->addressNumber,
            $this->districtCode,
            $this->zipCode
        );

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
    public function withAddressNumber(?string $addressNumber): LocationBuilder
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
    public function withDistrictCode(?int $districtCode): LocationBuilder
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
    public function withZipCode(?string $zipCode): LocationBuilder
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
            $this->latitude,
            $this->longitude,
            $this->addressNumber,
            $this->districtCode,
            $this->zipCode,
            $this->geometry
        );
    }
}
