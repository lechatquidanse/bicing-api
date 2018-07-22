<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Handler;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateRepositoryInterface;

class MockStationStateRepository implements StationStateRepositoryInterface
{
    /**
     * @var array
     */
    private $stationStates = [];

    public function add(StationState $stationState): void
    {
        $id = $this->stationStateId($stationState->statedAt(), $stationState->stationAssigned());

        $this->stationStates[$id] = $stationState;
    }

    public function find(DateTimeImmutableStringable $statedAt, Station $station): ?StationState
    {
        $id = $this->stationStateId($statedAt, $station);

        if (array_key_exists($id, $this->stationStates)) {
            return $this->stationStates[$id];
        }

        return null;
    }

    private function stationStateId(DateTimeImmutableStringable $statedAt, Station $station): string
    {
        return sprintf(
            '%s-%s',
            $statedAt,
            $station->stationId()->toString()
        );
    }
}
