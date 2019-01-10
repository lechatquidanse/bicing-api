<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use App\Infrastructure\BicingApi\AvailabilityStationQueryInterface;
use tests\Support\Builder\BicingApi\AvailabilityStationBuilder;

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
