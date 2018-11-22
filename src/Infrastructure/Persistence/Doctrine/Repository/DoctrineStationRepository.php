<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Exception\Station\StationAlreadyExistsException;
use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\UuidInterface;

final class DoctrineStationRepository implements StationRepositoryInterface
{
    /** @var string */
    private const EXCEPTION_NO_MANAGER_MESSAGE = 'No manager found for class Station';

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
     * {@inheritdoc}
     */
    public function add(Station $station): void
    {
        if (null !== $this->findByStationId($station->stationId())) {
            throw StationAlreadyExistsException::withStationId($station->stationId());
        }

        if (null !== $this->findByExternalStationId($station->externalStationId())) {
            throw StationAlreadyExistsException::withExternalStationId($station->externalStationId());
        }

        $this->manager()->persist($station);
        $this->manager()->flush();
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return Station|null
     */
    public function findByStationId(UuidInterface $stationId): ?Station
    {
        $station = $this->manager()->find(Station::class, $stationId);

        if ($station instanceof Station) {
            return $station;
        }

        return null;
    }

    /**
     * @param string $externalStationId
     *
     * @return Station|null
     */
    public function findByExternalStationId(string $externalStationId): ?Station
    {
        $station = $this->manager()
            ->getRepository(Station::class)
            ->findOneBy(['stationExternalData.externalStationId' => $externalStationId]);

        if ($station instanceof Station) {
            return $station;
        }

        return null;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->manager()->getRepository(Station::class)->findAll();
    }

    /**
     * @return ObjectManager
     */
    private function manager(): ObjectManager
    {
        $manager = $this->managerRegistry->getManagerForClass(Station::class);

        if (null === $manager) {
            throw new \RuntimeException(self::EXCEPTION_NO_MANAGER_MESSAGE);
        }

        return $manager;
    }
}
