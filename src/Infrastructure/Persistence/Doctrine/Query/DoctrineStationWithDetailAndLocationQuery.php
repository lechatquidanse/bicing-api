<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Domain\Model\Station\Station;
use App\Infrastructure\Persistence\Doctrine\Query\Filter\DoctrineByGeoLocationFilter;
use App\Infrastructure\Persistence\Doctrine\Query\Selector\DoctrineStationWithDetailAndLocationSelector;
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
     * {@inheritdoc}
     */
    public function findAll(ByGeoLocationFilter $filter = null): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select(DoctrineStationWithDetailAndLocationSelector::FIELD_SELECTOR)
            ->from(Station::class, 's');

        if (null !== $filter) {
            $queryBuilder = DoctrineByGeoLocationFilter::filter($queryBuilder, $filter);
        }

        return $queryBuilder->getQuery()
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
                ->select(DoctrineStationWithDetailAndLocationSelector::FIELD_SELECTOR)
                ->from(Station::class, 's')
                ->where('s.stationId = :stationId')
                ->setParameter('stationId', $stationId)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
