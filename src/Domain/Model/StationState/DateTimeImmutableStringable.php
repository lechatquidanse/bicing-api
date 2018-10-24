<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

/**
 * An immutable date time that can be displayed as string.
 *
 * @todo add test and validate construct
 */
final class DateTimeImmutableStringable extends \DateTimeImmutable
{
    /** @var string */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param \DateTimeImmutable $dateTimeImmutable
     *
     * @return DateTimeImmutableStringable
     */
    public static function fromDateTimeImmutable(\DateTimeImmutable $dateTimeImmutable): DateTimeImmutableStringable
    {
        return new self($dateTimeImmutable->format(self::DATE_FORMAT), $dateTimeImmutable->getTimezone());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format(self::DATE_FORMAT);
    }
}
