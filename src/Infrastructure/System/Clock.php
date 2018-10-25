<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Domain\Model\StationState\DateTimeImmutableStringable;

final class Clock implements ClockInterface
{
    /**
     * @param string $time
     *
     * @return \DateTimeImmutable
     *
     * @throws \Exception
     */
    public function dateTimeImmutable(string $time = 'now'): \DateTimeImmutable
    {
        return new \DateTimeImmutable($time);
    }

    /**
     * @param string $time
     *
     * @return DateTimeImmutableStringable
     *
     * @throws \Exception
     */
    public function dateTimeImmutableStringable(string $time = 'now'): DateTimeImmutableStringable
    {
        return new DateTimeImmutableStringable($time);
    }
}
