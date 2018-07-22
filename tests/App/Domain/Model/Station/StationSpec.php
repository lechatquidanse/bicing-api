<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\Station;

use App\Domain\Model\Station\Station;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\LocationBuilder;
use tests\Support\Builder\StationDetailBuilder;
use tests\Support\Builder\StationExternalDataBuilder;

/**
 * @see Station
 */
class StationSpec extends ObjectBehavior
{
    /**
     * Test that Station can be created.
     */
    public function it_can_be_created()
    {
        $this->beConstructedThrough('create', [
            Uuid::uuid4(),
            StationDetailBuilder::create()->build(),
            StationExternalDataBuilder::create()->build(),
            LocationBuilder::create()->build(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        ]);

        $this->shouldBeAnInstanceOf(Station::class);
    }

    /**
     * Test that Station can be created without optional value.
     */
    public function it_can_be_created_without_optional_value()
    {
        $this->beConstructedThrough('create', [
            Uuid::uuid4(),
            StationDetailBuilder::create()->build(),
            StationExternalDataBuilder::create()->build(),
            LocationBuilder::create()->build(),
            new \DateTimeImmutable(),
        ]);

        $this->shouldBeAnInstanceOf(Station::class);
    }
}
