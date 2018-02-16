<?php

namespace App\Application\UseCase\Command;

use App\Infrastructure\BicingApi\AvailabilityStation;

interface CreateStationCommandFactoryInterface
{
    public function fromAvailabilityStation(AvailabilityStation $availabilityStation): CreateStationCommand;
}
