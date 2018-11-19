<?php

declare(strict_types=1);

namespace App\Application\UseCase\Filter;

final class ByGeoLocationFilter
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var float */
    private $areaRestriction;

    /**
     * ByGeoLocationFilter constructor.
     *
     * @param float $latitude
     * @param float $longitude
     * @param float $areaRestriction
     */
    private function __construct(float $latitude, float $longitude, float $areaRestriction)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->areaRestriction = $areaRestriction;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $areaRestriction
     *
     * @return ByGeoLocationFilter
     */
    public static function fromRawValues(float $latitude, float $longitude, float $areaRestriction): self
    {
        return new self($latitude, $longitude, $areaRestriction);
    }

    /**
     * @return float
     */
    public function latitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function longitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function areaRestriction(): float
    {
        return $this->areaRestriction;
    }
}
