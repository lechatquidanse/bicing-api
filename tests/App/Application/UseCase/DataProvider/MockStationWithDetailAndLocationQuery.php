<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\DataProvider;

use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Domain\Model\Station\StationDetailType;
use Ramsey\Uuid\UuidInterface;

class MockStationWithDetailAndLocationQuery implements StationWithDetailAndLocationQueryInterface
{
    /** @var array */
    private $stations;

    /**
     * @param UuidInterface $stationId
     *
     * @return array|null
     */
    public function find(UuidInterface $stationId): ?array
    {
        return $this->stations[$stationId->toString()] ?? null;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->stations;
    }

    /**
     * @param UuidInterface     $stationId
     * @param string            $name
     * @param StationDetailType $type
     * @param string            $address
     * @param string            $addressNumber
     * @param string            $zipCode
     * @param float             $latitude
     * @param float             $longitude
     */
    public function addStationWithDetailAndLocation(
        UuidInterface $stationId,
        string $name,
        StationDetailType $type,
        string $address,
        string $addressNumber,
        string $zipCode,
        float $latitude,
        float $longitude
    ): void {
        $this->stations[$stationId->toString()] = [
            'station_id' => $stationId,
            'name' => $name,
            'type' => $type,
            'address' => $address,
            'address_number' => $addressNumber,
            'zip_code' => $zipCode,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }
}
