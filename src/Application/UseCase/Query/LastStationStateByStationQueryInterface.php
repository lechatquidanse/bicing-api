<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use Ramsey\Uuid\UuidInterface;

interface LastStationStateByStationQueryInterface
{
    /**
     * @param UuidInterface $stationId
     *
     * @return array[]|null
     */
    public function find(UuidInterface $stationId): ?array;

    /**
     * @return array[]
     */
    public function findAll(): array;
}
