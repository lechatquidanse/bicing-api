<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Domain\Model\StationState\DateTimeImmutableStringable;

interface ClockInterface
{
    /**
     * @param string $time
     *
     * @return \DateTimeImmutable
     */
    public function dateTimeImmutable(string $time = 'now'): \DateTimeImmutable;

    /**
     * @param string $time
     *
     * @return DateTimeImmutableStringable
     */
    public function dateTimeImmutableStringable(string $time = 'now'): DateTimeImmutableStringable;
}
