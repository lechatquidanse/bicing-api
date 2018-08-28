<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Exception\StationState\StationStateAlreadyExistsException;
use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;

class DoctrineStationStateRepository implements StationStateRepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param StationState $stationState
     */
    public function add(StationState $stationState): void
    {
        if (null !== $this->stationState($stationState->statedAt(), $stationState->stationAssigned())) {
            throw StationStateAlreadyExistsException::withStatedAtAndStationAssigned(
                $stationState->statedAt(),
                $stationState->stationAssigned()
            );
        }

        $this->manager()->persist($stationState);
        // @todo check if flush required
        $this->manager()->flush();
    }

    /**
     * @param DateTimeImmutableStringable $statedAt
     * @param Station                     $stationAssigned
     *
     * @return null|object
     */
    private function stationState(DateTimeImmutableStringable $statedAt, Station $stationAssigned)
    {
        return $this->manager()->find(StationState::class, ['statedAt' => $statedAt, 'stationAssigned' => $stationAssigned]);
    }

    /**
     * @return ObjectManager
     */
    private function manager(): ObjectManager
    {
        return $this->managerRegistry->getManagerForClass(StationState::class);
    }
}
