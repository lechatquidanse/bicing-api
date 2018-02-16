<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

interface AvailabilityStationQueryInterface
{
    /**
     * @return AvailabilityStation[]
     */
    public function findAll(): array;
}
