<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Statement;

use App\Application\UseCase\Handler\UpdateStationLocationGeometryStatementInterface;
use App\Domain\Model\Station\Station;
use App\Infrastructure\System\ClockInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class DoctrineUpdateStationLocationGeometryStatement implements UpdateStationLocationGeometryStatementInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ClockInterface */
    private $clock;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ClockInterface         $clock
     */
    public function __construct(EntityManagerInterface $entityManager, ClockInterface $clock)
    {
        $this->entityManager = $entityManager;
        $this->clock = $clock;
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function execute(UuidInterface $stationId)
    {
        return $this->entityManager->createQueryBuilder()
            ->update(Station::class, 's')
            ->set(
                's.location.geometry',
                'ST_Transform(ST_SetSRID(ST_MakePoint(s.location.longitude,s.location.latitude),4326),2163)'
            )
            ->set('s.updatedAt', ':updatedAt')
            ->where('s.stationId = :stationId')
            ->setParameters([
                'stationId' => $stationId,
                'updatedAt' => $this->clock->dateTimeImmutableStringable(),
            ])
            ->getQuery()
            ->execute();
    }
}
