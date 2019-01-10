<?php

declare(strict_types=1);

namespace App\Application\UseCase\Handler;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Domain\Model\Station\Location;
use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationDetail;
use App\Domain\Model\Station\StationExternalData;
use App\Domain\Model\Station\StationRepositoryInterface;

final class CreateStationHandler
{
    /**
     * @var StationRepositoryInterface
     */
    private $repository;

    /**
     * @param StationRepositoryInterface $repository
     */
    public function __construct(StationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateStationCommand $command
     */
    public function __invoke(CreateStationCommand $command)
    {
        $location = Location::fromRawValues(
            $command->address,
            $command->latitude,
            $command->longitude,
            $command->addressNumber,
            $command->districtCode,
            $command->zipCode
        );

        $this->repository->add(Station::create(
            $command->stationId,
            StationDetail::fromRawValues(
                $command->name,
                $command->type
            ),
            StationExternalData::fromRawValues(
                $command->externalStationId,
                $command->nearByExternalStationIds
            ),
            $location,
            $command->createdAt
        ));
    }
}
