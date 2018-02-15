<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

interface StationStateRepositoryInterface
{
    /**
     * @param StationState $stationState
     */
    public function add(StationState $stationState): void;
}
