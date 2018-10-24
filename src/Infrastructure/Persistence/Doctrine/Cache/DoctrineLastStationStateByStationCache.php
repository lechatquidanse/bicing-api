<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Cache;

use Doctrine\Common\Cache\FilesystemCache;

/** @todo add implement cache interface */
class DoctrineLastStationStateByStationCache
{
    /** @var string */
    public const COLLECTION_CACHE_KEY = 'doctrine.last_station_state_by_station.collection';

    /** @var FilesystemCache */
    private $cache;

    /**
     * @param FilesystemCache $cache
     */
    public function __construct(FilesystemCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param array $lastStationSateByStation
     * @param null  $ttl
     */
    public function set(array $lastStationSateByStation, $ttl = null): void
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
