<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Domain\Model\Station\Station;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

final class DoctrineStationWithDetailAndLocationQuery implements StationWithDetailAndLocationQueryInterface
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
            ->from(Station::class, 's')
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
                ->from(Station::class, 's')
                ->where('s.stationId = :stationId')
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
            's.stationId as station_id',
            's.stationDetail.name as name',
            's.stationDetail.type as type',
            's.location.address as address',
            's.location.addressNumber as address_number',
            's.location.zipCode as zip_code',
            's.location.latitude as latitude',
            's.location.longitude as longitude',
        ];
    }
}
