<?php

declare(strict_types=1);

namespace App\Application\UseCase\Handler;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\Station\StationRepositoryInterface;
use App\Domain\Model\StationState\StationStateRepositoryInterface;

final class AssignStationStateToStationHandler
{
    /**
     * @var StationRepositoryInterface
     */
    private $stationRepository;

    /**
     * @var StationStateRepositoryInterface
     */
    private $stationStateRepository;

    /**
     * @param StationRepositoryInterface      $stationRepository
     * @param StationStateRepositoryInterface $stationStateRepository
     */
    public function __construct(
        StationRepositoryInterface $stationRepository,
        StationStateRepositoryInterface $stationStateRepository
    ) {
        $this->stationRepository = $stationRepository;
        $this->stationStateRepository = $stationStateRepository;
    }

    /**
     * @param AssignStationStateToStationCommand $command
     *
     * @throws StationDoesNotExist if no station exists with the expected stationId
     */
    public function __invoke(AssignStationStateToStationCommand $command): void
    {
        $station = $this->stationRepository->findByExternalStationId($command->externalStationId);

        if (null === $station) {
            throw StationDoesNotExist::withExternalStationId($command->externalStationId);
        }

        $this->stationStateRepository->add($station->assignStationState(
            $command->statedAt,
            $command->availableBikeNumber,
            $command->availableSlotNumber,
            $command->status,
            $command->createdAt
        ));
    }
}
