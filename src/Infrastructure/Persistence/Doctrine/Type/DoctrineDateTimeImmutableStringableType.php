<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType as BaseDateTimeImmutableType;

final class DoctrineDateTimeImmutableStringableType extends BaseDateTimeImmutableType
{
    /**
     * @var string
     */
    const NAME = 'date_time_immutable_stringable';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return DateTimeImmutableStringable|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeImmutableStringable
    {
        if (null === $value || $value instanceof DateTimeImmutableStringable) {
            return $value;
        }

        $baseDateTimeImmutable = parent::convertToPHPValue($value, $platform);

        if (!($baseDateTimeImmutable instanceof \DateTimeImmutable)) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return DateTimeImmutableStringable::fromDateTimeImmutable($baseDateTimeImmutable);
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
