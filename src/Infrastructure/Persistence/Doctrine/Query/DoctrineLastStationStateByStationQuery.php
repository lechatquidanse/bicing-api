<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Domain\Model\StationState\StationState;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
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
        return $this->entityManager->createQueryBuilder()
            ->select(self::expectedFields())
            ->from(StationState::class, 'ss')
            ->leftJoin(
                StationState::class,
                'ss_join',
                Join::WITH,
                'ss.stationAssigned = ss_join.stationAssigned AND ss.statedAt < ss_join.statedAt'
            )
            ->where('ss_join.stationAssigned IS NULL')
            ->getQuery()
            ->getResult();
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
                ->select(self::expectedFields())
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

    /**
     * @return array
     */
    private static function expectedFields(): array
    {
        return [
            'IDENTITY(ss.stationAssigned) as station_id',
            'ss.statedAt as stated_at',
            'ss.availableBikeNumber as available_bike_number',
            'ss.availableSlotNumber as available_slot_number',
            'ss.status as status',
        ];
    }
}
