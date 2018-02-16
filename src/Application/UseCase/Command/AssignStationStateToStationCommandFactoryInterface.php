<?php

namespace App\Application\UseCase\Command;

use App\Infrastructure\BicingApi\AvailabilityStation;

interface AssignStationStateToStationCommandFactoryInterface
{
    public function fromAvailabilityStation(AvailabilityStation $availabilityStation): AssignStationStateToStationCommand;
}
