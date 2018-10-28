<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query;

use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Infrastructure\Persistence\Doctrine\Cache\DoctrineLastStationStateByStationCache;
use Ramsey\Uuid\UuidInterface;

final class DoctrineLastStationStateByStationQueryCache implements LastStationStateByStationQueryInterface
{
    /** @var LastStationStateByStationQueryInterface */
    private $query;

    /** @var DoctrineLastStationStateByStationCache */
    private $cache;

    /**
     * @param LastStationStateByStationQueryInterface $query
     * @param DoctrineLastStationStateByStationCache  $cache
     */
    public function __construct(
        LastStationStateByStationQueryInterface $query,
        DoctrineLastStationStateByStationCache $cache
    ) {
        $this->query = $query;
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        if ($items = $this->cache->get()) {
            return $items;
        }

        $items = $this->query->findAll();

        $this->cache->set($items);

        return $items;
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return array|null
     */
    public function find(UuidInterface $stationId): ?array
    {
        return $this->query->find($stationId);
    }
}
