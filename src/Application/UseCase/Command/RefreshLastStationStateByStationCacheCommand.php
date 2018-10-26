<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\UseCase;

final class RefreshLastStationStateByStationCacheCommand implements UseCase
{
    /**
     * @var int
     */
    public $ttl;
}
