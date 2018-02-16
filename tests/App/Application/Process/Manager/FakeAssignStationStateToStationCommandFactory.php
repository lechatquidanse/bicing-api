<?php

declare(strict_types=1);

namespace Tests\App\Application\Process\Manager;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Application\UseCase\Command\AssignStationStateToStationCommandFactoryInterface;
use App\Infrastructure\BicingApi\AvailabilityStation;
use Tests\Support\Builder\StationStateStatusBuilder;

class FakeAssignStationStateToStationCommandFactory implements AssignStationStateToStationCommandFactoryInterface
{
    public function fromAvailabilityStation(AvailabilityStation $availabilityStation): AssignStationStateToStationCommand
    {
        $command = new AssignStationStateToStationCommand();

        $command->externalStationId   = '122';
        $command->status              = StationStateStatusBuilder::create()->build();
        $command->availableBikeNumber = 12;
        $command->availableSlotNumber = 7;

        return $command;
    }
}
