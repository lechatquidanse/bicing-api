<?php

declare(strict_types=1);

namespace App\Domain\Exception\Station;

use App\Domain\Exception\DomainException;

final class StationDoesNotExist extends \DomainException implements DomainException
{
    /**
     * @param string $externalStationId
     *
     * @return StationDoesNotExist
     */
    public static function withExternalStationId(string $externalStationId): self
    {
        return new self(sprintf('A station does not exist with external station Id "%s".', $externalStationId));
    }
}
