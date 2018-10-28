<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationStateStatus;
use Ramsey\Uuid\UuidInterface;

class MockLastStationStateByStationQuery implements LastStationStateByStationQueryInterface
{
    /** @var array */
    private $stationStates;

    /**
     * @param UuidInterface $stationId
     *
     * @return array|null
     */
    public function find(UuidInterface $stationId): ?array
    {
        return $this->stationStates[$stationId->toString()] ?? null;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->stationStates;
    }

    /**
     * @param UuidInterface               $stationId
     * @param DateTimeImmutableStringable $statedAt
     * @param int                         $availableBikeNumber
     * @param int                         $availableSlotNumber
     * @param StationStateStatus          $status
     */
    public function addStationSateWithData(
        UuidInterface $stationId,
        DateTimeImmutableStringable $statedAt,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status
    ): void {
        $this->stationStates[$stationId->toString()] = [
            'station_id' => $stationId,
            'stated_at' => $statedAt,
            'available_bike_number' => $availableBikeNumber,
            'available_slot_number' => $availableSlotNumber,
            'status' => $status,
        ];
    }
}
