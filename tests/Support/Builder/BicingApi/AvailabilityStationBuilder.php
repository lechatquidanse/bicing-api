<?php

declare(strict_types=1);

namespace tests\Support\Builder\BicingApi;

use App\Infrastructure\BicingApi\Availability;
use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\BicingApi\Location;
use App\Infrastructure\BicingApi\Station;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\BuilderInterface;

class AvailabilityStationBuilder implements BuilderInterface
{
    /** @var string */
    private $id;

    /** @var Availability */
    private $availability;

    /** @var Station */
    private $station;

    /** @var Location */
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

    public static function create()
    {
        return new self(
            Uuid::uuid4()->toString(),
            AvailabilityBuilder::create()->build(),
            StationBuilder::create()->build(),
            LocationBuilder::create()->build()
        );
    }

    public function withId(string $id): AvailabilityStationBuilder
    {
        $copy = $this->copy();
        $copy->id = $id;

        return $copy;
    }

    public function withAvailability(Availability $availability): AvailabilityStationBuilder
    {
        $copy = $this->copy();
        $copy->availability = $availability;

        return $copy;
    }

    public function withStation(Station $station): AvailabilityStationBuilder
    {
        $copy = $this->copy();
        $copy->station = $station;

        return $copy;
    }

    public function withLocation(Location $location): AvailabilityStationBuilder
    {
        $copy = $this->copy();
        $copy->location = $location;

        return $copy;
    }

    public function build()
    {
        return AvailabilityStation::create($this->id, $this->availability, $this->station, $this->location);
    }

    private function copy(): AvailabilityStationBuilder
    {
        return new self($this->id, $this->availability, $this->station, $this->location);
    }
}
