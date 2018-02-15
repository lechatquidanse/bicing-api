<?php

declare(strict_types=1);

namespace App\Domain\Exception\Station;

use App\Domain\Exception\DomainException;

final class StationDetailTypeIsInvalidException extends \DomainException implements DomainException
{
    /**
     * @param string $type
     *
     * @return StationDetailTypeIsInvalidException
     */
    public static function withType(string $type): StationDetailTypeIsInvalidException
    {
        return new self(sprintf('StationDetailType with type "%s" is invalid', $type));
    }
}
