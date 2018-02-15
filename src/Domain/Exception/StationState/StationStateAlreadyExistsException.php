<?php

declare(strict_types=1);

namespace App\Domain\Exception\StationState;

use App\Domain\Exception\DomainException;
use App\Domain\Model\Station\Station;

final class StationStateAlreadyExistsException extends \DomainException implements DomainException
{
    /**
     * @param \DateTimeImmutable $statedAt
     * @param Station            $stationAssigned
     *
     * @return StationStateAlreadyExistsException
     */
    public static function withStatedAtAndStationAssigned(\DateTimeImmutable $statedAt, Station $stationAssigned): self
    {
        return new self(sprintf(
            'A station state already exists with stated at "%s" and station assigned Id "%s".',
            $statedAt->format('Y-m-d H:i:s'),
            $stationAssigned->stationId()->toString()
        ));
    }
}
