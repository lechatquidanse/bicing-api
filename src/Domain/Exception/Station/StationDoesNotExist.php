<?php

declare(strict_types=1);

namespace App\Domain\Exception\Station;

use App\Domain\Exception\DomainExceptionInterface;

final class StationDoesNotExist extends \DomainException implements DomainExceptionInterface
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
