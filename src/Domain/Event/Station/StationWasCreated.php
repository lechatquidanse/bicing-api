<?php

declare(strict_types=1);

namespace App\Domain\Event\Station;

use App\Domain\Event\DomainEventInterface;
use Ramsey\Uuid\UuidInterface;

final class StationWasCreated implements DomainEventInterface
{
    /** @var UuidInterface */
    private $stationId;

    /**
     * @param UuidInterface $stationId
     */
    public function __construct(UuidInterface $stationId)
    {
        $this->stationId = $stationId;
    }

    /**
     * @return UuidInterface
     */
    public function stationId(): UuidInterface
    {
        return $this->stationId;
    }
}
