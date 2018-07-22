<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\StationState;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use Assert\LazyAssertionException;
use PhpSpec\ObjectBehavior;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationStateStatusBuilder;


/**
 * @see StationState
 */
class StationStateSpec extends ObjectBehavior
{
    /**
     * Test that StationState can be created.
     */
    public function it_can_be_created()
    {
        $this->beConstructedThrough('create', [
            new DateTimeImmutableStringable(),
            StationBuilder::create()->build(),
            7,
            18,
            StationStateStatusBuilder::create()->build(),
            new \DateTimeImmutable(),
        ]);

        $this->shouldBeAnInstanceOf(StationState::class);
    }

    /**
     * Test that a StationState can not be created with negative available bike number.
     */
    public function it_can_not_be_created_with_negative_available_bike_number()
    {
        $this->beConstructedThrough('create', [
            new DateTimeImmutableStringable(),
            StationBuilder::create()->build(),
            -1,
            18,
            StationStateStatusBuilder::create()->build(),
            new \DateTimeImmutable(),
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a StationState can not be created with negative available slot number.
     */
    public function it_can_not_be_created_with_negative_available_slot_number()
    {
        $this->beConstructedThrough('create', [
            new DateTimeImmutableStringable(),
            StationBuilder::create()->build(),
            7,
            -1,
            StationStateStatusBuilder::create()->build(),
            new \DateTimeImmutable(),
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }
}
