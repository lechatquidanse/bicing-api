<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Statement;

use App\Application\UseCase\Handler\UpdateStationLocationGeometryStatementInterface;
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
     * @return bool
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function execute(UuidInterface $stationId): bool
    {
        $query = <<<SQLUPDATE
UPDATE station
SET 
  location_geometry = ST_Transform(ST_SetSRID(ST_MakePoint(location_longitude,location_latitude),4326),2163),
  updated_at = :updatedAt
WHERE station_id = :stationId
SQLUPDATE;

        $statement = $this->entityManager->getConnection()->prepare($query);

        $statement->bindValue('stationId', $stationId->toString());
        $statement->bindValue('updatedAt', $this->clock->dateTimeImmutableStringable());

        return $statement->execute();
    }
}
