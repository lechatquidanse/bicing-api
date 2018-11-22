<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Cache;

use Doctrine\Common\Cache\Cache;

final class DoctrineLastStationStateByStationCache
{
    /** @var string */
    public const COLLECTION_CACHE_KEY = 'doctrine.last_station_state_by_station.collection';

    /** @var Cache */
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param array $lastStationSateByStation
     * @param int   $ttl
     */
    public function set(array $lastStationSateByStation, $ttl = 0): void
    {
        $this->cache->save(static::COLLECTION_CACHE_KEY, $lastStationSateByStation, $ttl);
    }

    /**
     * @return false|array
     */
    public function get()
    {
        return $this->cache->fetch(static::COLLECTION_CACHE_KEY);
    }
}
