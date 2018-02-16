<?php

declare(strict_types=1);

namespace Tests\App\Application\Process\Manager;

use App\Infrastructure\BicingApi\AvailabilityStationQueryInterface;
use Tests\Support\Builder\AvailabilityStationBuilder;

class FakeAvailabilityStationQuery implements AvailabilityStationQueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return [
            AvailabilityStationBuilder::create()->build(),
            AvailabilityStationBuilder::create()->build(),
        ];
    }
}
