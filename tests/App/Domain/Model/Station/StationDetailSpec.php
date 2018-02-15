<?php

declare(strict_types=1);

namespace Tests\App\Domain\Model\Station;

use App\Domain\Model\Station\StationDetail;
use Assert\LazyAssertionException;
use PhpSpec\ObjectBehavior;
use Tests\Support\Builder\StationDetailTypeBuilder;

/**
 * @see StationDetail
 */
class StationDetailSpec extends ObjectBehavior
{
    /**
     * Test that StationDetail can be created from raw values.
     */
    public function it_can_be_created_from_raw_values()
    {
        $this->beConstructedThrough('fromRawValues', [
            '34 - C/ SANT PERE MÉS ALT, 4',
            StationDetailTypeBuilder::create()->build(),
        ]);

        $this->shouldBeAnInstanceOf(StationDetail::class);
    }

    /**
     * Test that a StationDetail can not be created with an empty name.
     */
    public function it_can_not_be_created_with_empty_external_station_id()
    {
        $this->beConstructedThrough('fromRawValues', [
            '',
            StationDetailTypeBuilder::create()->build(),
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }
}
