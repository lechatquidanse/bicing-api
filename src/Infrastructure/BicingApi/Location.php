<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use JMS\Serializer\Annotation as Serializer;

final class Location
{
    /**
     * @Serializer\Type("float")
     *
     * @var float
     */
    private $longitude;

    /**
     * @Serializer\Type("float")
     *
     * @var float
     */
    private $latitude;

    /**
     * @Serializer\SerializedName("streetName")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $address;

    /**
     * @Serializer\SerializedName("streetNumber")
     * @Serializer\Type("string")
     *
     * @var string|null
     */
    private $addressNumber;

    /**
     * @Serializer\SkipWhenEmpty()
     *
     * @var int|null
     */
    private $districtCode;

    /**
     * @Serializer\SkipWhenEmpty()
     * @Serializer\Type("string")
     *
     * @var string|null
     */
    private $zipCode;

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

    public static function fromRawValues(
        float $longitude,
        float $latitude,
        string $address,
        ?string $addressNumber,
        ?int $districtCode,
        ?string $zipCode
    ): Location {
        return new self($longitude, $latitude, $address, $addressNumber, $districtCode, $zipCode);
    }

    /**
     * @return int|null
     */
    public function districtCode(): ?int
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
     * @return string|null
     */
    public function zipCode(): ?string
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
    public function addressNumber(): ?string
    {
        return $this->addressNumber;
    }
}
