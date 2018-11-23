<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodFilterQueryInterface;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateStatus;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class DoctrineStationAvailabilitiesByIntervalInPeriodFilterQuery implements StationAvailabilitiesByIntervalInPeriodFilterQueryInterface  // phpcs:ignore
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

    public function find(UuidInterface $stationId, ByIntervalInPeriodFilter $filter): array
    {
        $selectInterval = sprintf('time_bucket(\'%s\', ss.statedAt) AS interval', $filter->interval());

        return $this->entityManager->createQueryBuilder()
            ->select([
                $selectInterval,
                'avg(ss.availableBikeNumber) as available_bike_avg',
                'min(ss.availableBikeNumber) as available_bike_min',
                'max(ss.availableBikeNumber) as available_bike_max',
                'avg(ss.availableSlotNumber) as available_slot_avg',
                'min(ss.availableSlotNumber) as available_slot_min',
                'max(ss.availableSlotNumber) as available_slot_max',
            ])
            ->from(StationState::class, 'ss')
            ->where('ss.status = :status')
            ->andWhere('ss.stationAssigned = :stationId')
            ->andWhere('ss.statedAt > :intervalDown')
            ->andWhere('ss.statedAt < :intervalUp')
            ->groupBy('interval')
            ->orderBy('interval')
            ->setParameters([
                'status' => StationStateStatus::STATUS_OPENED,
                'stationId' => $stationId->toString(),
                'intervalDown' => $filter->periodStartAsString(),
                'intervalUp' => $filter->periodEndAsString(),
            ])
            ->getQuery()
            ->getResult();
    }
}
