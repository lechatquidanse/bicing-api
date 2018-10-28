<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

use App\Domain\Model\ValueObjectInterface;

/**
 * An immutable date time that can be displayed as string.
 */
final class DateTimeImmutableStringable extends \DateTimeImmutable implements ValueObjectInterface
{
    /** @var string */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param \DateTimeImmutable $dateTimeImmutable
     *
     * @return DateTimeImmutableStringable
     *
     * @throws \Exception
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
