<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\UseCaseInterface;

final class RefreshLastStationStateByStationCacheCommand implements UseCaseInterface
{
    /**
     * @var int
     */
    private $ttl;

    /**
     * RefreshLastStationStateByStationCacheCommand constructor.
     *
     * @param int $ttl
     */
    private function __construct(int $ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * @param int $ttl
     *
     * @return RefreshLastStationStateByStationCacheCommand
     */
    public static function create(int $ttl): self
    {
        return new self($ttl);
    }

    /**
     * @return int
     */
    public function ttl(): int
    {
        return $this->ttl;
    }
}
