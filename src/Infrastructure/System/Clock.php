<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Domain\Model\StationState\DateTimeImmutableStringable;

/**
 * @todo add test
 */
class Clock implements ClockInterface
{
    /**
     * @param string $time
     *
     * @return \DateTimeImmutable
     */
    public function dateTimeImmutable(string $time = 'now'): \DateTimeImmutable
    {
        return new \DateTimeImmutable($time);
    }

    public function dateTimeImmutableStringable(string $time = 'now'): DateTimeImmutableStringable
    {
        return new DateTimeImmutableStringable($time);
    }
}
