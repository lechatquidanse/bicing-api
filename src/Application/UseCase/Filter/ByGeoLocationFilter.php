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
    private $limit;

    /**
     * ByGeoLocationFilter constructor.
     *
     * @param float $latitude
     * @param float $longitude
     * @param float $limit
     */
    private function __construct(float $latitude, float $longitude, float $limit)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->limit = $limit;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $limit
     *
     * @return ByGeoLocationFilter
     */
    public static function fromRawValues(float $latitude, float $longitude, float $limit): self
    {
        return new self($latitude, $longitude, $limit);
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
     * @return float
     */
    public function limit(): float
    {
        return $this->limit;
    }
}
