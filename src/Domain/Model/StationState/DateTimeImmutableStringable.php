<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

/**
 * An immutable date time that can be displayed as string.
 */
final class DateTimeImmutableStringable extends \DateTimeImmutable
{
    /**
     * @param \DateTimeImmutable $dateTimeImmutable
     *
     * @return DateTimeImmutableStringable
     */
    public static function fromDateTimeImmutable(\DateTimeImmutable $dateTimeImmutable): DateTimeImmutableStringable
    {
        $self = new self();

        $self
            ->setTimestamp($dateTimeImmutable->getTimestamp())
            ->setTimezone($dateTimeImmutable->getTimezone());

        return $self;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }
}
