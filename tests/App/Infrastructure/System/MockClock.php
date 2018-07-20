<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\System;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\System\ClockInterface;

class MockClock implements ClockInterface
{
    /**
     * @var \DateTimeImmutable
     */
    private static $willReturnDateTimeImmutable;

    /**
     * @var DateTimeImmutableStringable
     */
    private static $willReturnDateTimeImmutableStringable;

    /**
     * {@inheritdoc}
     */
    public function dateTimeImmutable(string $time = 'now'): \DateTimeImmutable
    {
        if (null !== self::$willReturnDateTimeImmutable) {
            return self::$willReturnDateTimeImmutable;
        }

        return new \DateTimeImmutable($time);
    }

    /**
     * {@inheritdoc}
     */
    public function dateTimeImmutableStringable(string $time = 'now'): DateTimeImmutableStringable
    {
        if (null !== self::$willReturnDateTimeImmutableStringable) {
            return self::$willReturnDateTimeImmutableStringable;
        }

        return new DateTimeImmutableStringable($time);
    }

    public static function willReturnDateTimeImmutable(\DateTimeImmutable $date): void
    {
        self::$willReturnDateTimeImmutable = $date;
    }

    public static function willReturnDateTimeImmutableStringable(DateTimeImmutableStringable $date): void
    {
        self::$willReturnDateTimeImmutableStringable = $date;
    }

    public static function reset(): void
    {
        self::$willReturnDateTimeImmutableStringable = null;
        self::$willReturnDateTimeImmutable           = null;
    }
}
