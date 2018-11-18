<?php

declare(strict_types=1);

namespace App\Domain\Exception\StationState;

use App\Domain\Exception\DomainExceptionInterface;

final class StationStateStatusIsInvalidException extends \DomainException implements DomainExceptionInterface
{
    /**
     * @param string $status
     *
     * @return StationStateStatusIsInvalidException
     */
    public static function withStatus(string $status): StationStateStatusIsInvalidException
    {
        return new self(sprintf('StationStateStatus with status "%s" is invalid', $status));
    }
}
