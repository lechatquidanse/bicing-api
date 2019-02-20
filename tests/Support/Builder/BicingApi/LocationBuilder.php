<?php

declare(strict_types=1);

namespace tests\Support\Builder\BicingApi;

use App\Infrastructure\BicingApi\Location;
use tests\Support\Builder\BuilderInterface;

final class LocationBuilder implements BuilderInterface
{
    /** @var float */
    private $longitude;

    /** @var float */
    private $latitude;

    /** @var string */
    private $address;

    /** @var string|null */
    private $addressNumber;

    /** @var int|null */
    private $districtCode;

    /** @var string|null */
    private $zipCode;

    /**
     * @param float       $longitude
     * @param float       $latitude
     * @param string      $address
     * @param string|null $addressNumber
     * @param int|null    $districtCode
     * @param string|null $zipCode
     */
    private function __construct(
        float $longitude,
        float $latitude,
        string $address,
        ?string $addressNumber,
        ?int $districtCode,
        ?string $zipCode
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->addressNumber = $addressNumber;
        $this->districtCode = $districtCode;
        $this->zipCode = $zipCode;
    }

    public static function create(): LocationBuilder
    {
        return new self(
            41.324,
            2.123,
            'A station address',
            null,
            null,
            null
        );
    }

    public function build()
    {
        return Location::fromRawValues(
            $this->longitude,
            $this->latitude,
            $this->address,
            $this->addressNumber,
            $this->districtCode,
            $this->zipCode
        );
    }

    public function withLongitude(float $longitude): LocationBuilder
    {
        $copy = $this->copy();
        $copy->longitude = $longitude;

        return $copy;
    }

    public function withLatitude(float $latitude): LocationBuilder
    {
        $copy = $this->copy();
        $copy->latitude = $latitude;

        return $copy;
    }

    public function withAddress(string $address): LocationBuilder
    {
        $copy = $this->copy();
        $copy->address = $address;

        return $copy;
    }

    public function withAddressNumber(?string $addressNumber): LocationBuilder
    {
        $copy = $this->copy();
        $copy->addressNumber = $addressNumber;

        return $copy;
    }

    public function withDistrictCode(?int $districtCode): LocationBuilder
    {
        $copy = $this->copy();
        $copy->districtCode = $districtCode;

        return $copy;
    }

    public function withZipCode(?string $zipCode): LocationBuilder
    {
        $copy = $this->copy();
        $copy->zipCode = $zipCode;

        return $copy;
    }

    private function copy(): LocationBuilder
    {
        return new self(
            $this->longitude,
            $this->latitude,
            $this->address,
            $this->addressNumber,
            $this->districtCode,
            $this->zipCode
        );
    }
}
