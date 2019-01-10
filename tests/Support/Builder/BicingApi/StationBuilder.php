<?php

declare(strict_types=1);

namespace tests\Support\Builder\BicingApi;

use App\Domain\Model\Station\StationDetailType;
use App\Infrastructure\BicingApi\Station;
use tests\Support\Builder\BuilderInterface;

final class StationBuilder implements BuilderInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var array|null */
    private $nearByStationIds;

    /**
     * @param string     $name
     * @param string     $type
     * @param array|null $nearByStationIds
     */
    public function __construct(string $name, string $type, ?array $nearByStationIds)
    {
        $this->name = $name;
        $this->type = $type;
        $this->nearByStationIds = $nearByStationIds;
    }

    public static function create(): StationBuilder
    {
        return new self(
            '477',
            StationDetailType::TYPE_BIKE,
            null
        );
    }

    public function build()
    {
        return Station::fromRawValues($this->name, $this->type, $this->nearByStationIds);
    }

    public function withName(string $name): StationBuilder
    {
        $copy = $this->copy();
        $copy->name = $name;

        return $copy;
    }

    public function withType(string $type): StationBuilder
    {
        $copy = $this->copy();
        $copy->type = $type;

        return $copy;
    }

    public function withNearByStationIds(array $nearByStationIds = null): StationBuilder
    {
        $copy = $this->copy();
        $copy->nearByStationIds = $nearByStationIds;

        return $copy;
    }

    private function copy(): StationBuilder
    {
        return new self($this->name, $this->type, $this->nearByStationIds);
    }
}
