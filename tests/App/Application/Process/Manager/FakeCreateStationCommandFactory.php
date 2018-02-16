<?php

declare(strict_types=1);

namespace Tests\App\Application\Process\Manager;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Application\UseCase\Command\CreateStationCommandFactoryInterface;
use App\Infrastructure\BicingApi\AvailabilityStation;
use Tests\Support\Builder\StationDetailTypeBuilder;

class FakeCreateStationCommandFactory implements CreateStationCommandFactoryInterface
{
    public function fromAvailabilityStation(AvailabilityStation $availabilityStation): CreateStationCommand
    {
        $command = new CreateStationCommand();

        $command->name                     = '02 - C/ ROGER DE FLOR, 126';
        $command->type                     = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $command->externalStationId        = '2';
        $command->nearByExternalStationIds = ['360', '368', '387', '414'];
        $command->address                  = 'Roger de Flor/ Gran Vía';
        $command->addressNumber            = '126';
        $command->districtCode             = 2;
        $command->zipCode                  = '08010';
        $command->latitude                 = 41.39553;
        $command->longitude                = 2.17706;

        return $command;
    }
}
