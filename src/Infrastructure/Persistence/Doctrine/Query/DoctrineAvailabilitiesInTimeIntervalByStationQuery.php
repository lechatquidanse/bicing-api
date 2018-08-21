<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationQueryInterface;
use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationView;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateStatus;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrineAvailabilitiesInTimeIntervalByStationQuery implements AvailabilitiesInTimeIntervalByStationQueryInterface
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
     * @param UuidInterface $stationId
     *
     * @return AvailabilitiesInTimeIntervalByStationView
     */
    public function find(UuidInterface $stationId): AvailabilitiesInTimeIntervalByStationView
    {
        $lastWeekAt = new \DateTimeImmutable('last week');
        $intervalUpAt = $lastWeekAt->modify('+1 hour');
        $intervalDownAt = $lastWeekAt->modify('-1 hour');

        $results = $this->entityManager->createQueryBuilder()
            ->select([
                'time_bucket(\'10 minute\', ss.statedAt) AS interval',
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
                'stationId' => $stationId,
                'intervalUp' => $intervalUpAt->format('Y-m-d H:i:s'),
                'intervalDown' => $intervalDownAt->format('Y-m-d H:i:s'),
            ])
            ->getQuery()
            ->getResult();

        if (empty($results)) {
            return new AvailabilitiesInTimeIntervalByStationView([]);
        }

        return new AvailabilitiesInTimeIntervalByStationView($results);
    }
}
