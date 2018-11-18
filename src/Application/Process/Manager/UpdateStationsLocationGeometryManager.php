<?php

declare(strict_types=1);

namespace App\Application\Process\Manager;

use App\Application\UseCase\Command\UpdateStationLocationGeometryCommand;
use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationRepositoryInterface;
use SimpleBus\Message\Bus\MessageBus;

final class UpdateStationsLocationGeometryManager
{
    /**
     * @var StationRepositoryInterface
     */
    private $repository;

    /** @var MessageBus */
    private $commandBus;

    /**
     * @param StationRepositoryInterface $query
     * @param MessageBus                 $commandBus
     */
    public function __construct(StationRepositoryInterface $repository, MessageBus $commandBus)
    {
        $this->repository = $repository;
        $this->commandBus = $commandBus;
    }

    public function __invoke(): void
    {
        $stations = $this->repository->findAll();

        /** @var Station $station */
        foreach ($stations as $station) {
            $this->commandBus->handle(UpdateStationLocationGeometryCommand::create($station->stationId()));
        }
    }
}
