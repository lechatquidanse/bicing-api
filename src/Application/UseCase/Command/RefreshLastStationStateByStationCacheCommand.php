<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\UseCaseInterface;

final class RefreshLastStationStateByStationCacheCommand implements UseCaseInterface
{
    /**
     * @var int
     */
    public $ttl;
}
