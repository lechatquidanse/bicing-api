<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Domain\Model\StationState\StationState;
use App\Infrastructure\Persistence\Doctrine\Query\Selector\DoctrineLastStationStateByStationSelector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

final class DoctrineLastStationStateByStationQuery implements LastStationStateByStationQueryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        try {
            $lastStatedAt = $this->entityManager->createQueryBuilder()
                ->select('ss.statedAt')
                ->from(StationState::class, 'ss')
                ->orderBy('ss.statedAt', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            if (false === is_array($lastStatedAt) || false === isset($lastStatedAt['statedAt'])) {
                return [];
            }

            return $this->entityManager->createQueryBuilder()
                ->select(DoctrineLastStationStateByStationSelector::select('ss'))
                ->from(StationState::class, 'ss')
                ->where('ss.statedAt = :statedAt')
                ->setParameters(['statedAt' => $lastStatedAt['statedAt']])
                ->getQuery()
                ->getResult();
        } catch (NonUniqueResultException $exception) {
            return [];
        }
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return array|null
     */
    public function find(UuidInterface $stationId): ?array
    {
        try {
            return $this->entityManager->createQueryBuilder()
                ->select(DoctrineLastStationStateByStationSelector::select('ss'))
                ->from(StationState::class, 'ss')
                ->where('ss.stationAssigned = :stationId')
                ->orderBy('ss.statedAt', 'DESC')
                ->setMaxResults(1)
                ->setParameter('stationId', $stationId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
