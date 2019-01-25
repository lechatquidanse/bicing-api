<?php

declare(strict_types=1);

namespace App\Application\UseCase\Handler;

use App\Application\UseCase\Command\RefreshLastStationStateByStationCacheCommand;
use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Infrastructure\Persistence\Doctrine\Cache\DoctrineLastStationStateByStationCache;

final class RefreshLastStationStateByStationCacheHandler
{
    /**
     * @var LastStationStateByStationQueryInterface
     */
    private $query;

    /**
     * @var DoctrineLastStationStateByStationCache
     */
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
     * @param RefreshLastStationStateByStationCacheCommand $command
     */
    public function __invoke(RefreshLastStationStateByStationCacheCommand $command): void
    {
        $this->cache->set($this->query->findAll(), $command->ttl());
    }
}
