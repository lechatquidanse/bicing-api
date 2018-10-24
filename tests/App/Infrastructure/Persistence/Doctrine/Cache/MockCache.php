<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Cache;

use Doctrine\Common\Cache\Cache;

class MockCache implements Cache
{
    /** @var array */
    private $cache = [];

    public function fetch($id)
    {
        if (true === $this->contains($id)) {
            return $this->cache[$id];
        }

        return false;
    }

    public function contains($id): bool
    {
        return isset($this->cache[$id]);
    }

    public function save($id, $data, $lifeTime = 0)
    {
        $this->cache[$id] = $data;
    }

    public function delete($id)
    {
        if (true === $this->contains($id)) {
            unset($this->cache[$id]);
        }
    }

    public function getStats()
    {
    }
}
