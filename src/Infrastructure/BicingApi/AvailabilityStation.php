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
     * @Serializer\Inline()
     * @Serializer\Type("App\Infrastructure\BicingApi\Availability")
     *
     * @var Availability
     */
    private $availability;

    /**
     * @Serializer\Inline()
     * @Serializer\Type("App\Infrastructure\BicingApi\Station")
     *
     * @var Station
     */
    private $station;

    /**
     * @Serializer\Inline()
     * @Serializer\Type("App\Infrastructure\BicingApi\Location")
     *
     * @var Location
     */
    private $location;

    /**
     * @param string       $id
     * @param Availability $availability
     * @param Station      $station
     * @param Location     $location
     */
    private function __construct(string $id, Availability $availability, Station $station, Location $location)
    {
        $this->id = $id;
        $this->availability = $availability;
        $this->station = $station;
        $this->location = $location;
    }

    /**
     * @param string       $id
     * @param Availability $availability
     * @param Station      $station
     * @param Location     $location
     *
     * @return AvailabilityStation
     */
    public static function create(
        string $id,
        Availability $availability,
        Station $station,
        Location $location
    ): AvailabilityStation {
        return new self($id, $availability, $station, $location);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return Availability
     */
    public function availability(): Availability
    {
        return $this->availability;
    }

    /**
     * @return Station
     */
    public function station(): Station
    {
        return $this->station;
    }

    /**
     * @return Location
     */
    public function location(): Location
    {
        return $this->location;
    }
}
