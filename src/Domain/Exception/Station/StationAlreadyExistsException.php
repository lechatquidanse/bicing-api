<?php

declare(strict_types=1);

namespace App\Domain\Exception\Station;

use App\Domain\Exception\DomainExceptionInterface;
use Ramsey\Uuid\UuidInterface;

final class StationAlreadyExistsException extends \DomainException implements DomainExceptionInterface
{
    /**
     * @param UuidInterface $stationId
     *
     * @return StationAlreadyExistsException
     */
    public static function withStationId(UuidInterface $stationId): self
    {
        return new self(sprintf('A station already exists with station Id "%s".', $stationId->toString()));
    }

    /**
     * @param string $externalStationId
     *
     * @return StationAlreadyExistsException
     */
    public static function withExternalStationId(string $externalStationId): self
    {
        return new self(sprintf('A station already exists with external station Id "%s".', $externalStationId));
    }
}
