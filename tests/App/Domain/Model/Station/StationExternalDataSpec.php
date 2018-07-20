<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\Station;

use App\Domain\Model\Station\StationExternalData;
use Assert\LazyAssertionException;
use PhpSpec\ObjectBehavior;

/**
 * @see StationExternalData
 */
class StationExternalDataSpec extends ObjectBehavior
{
    /**
     * Test that StationExternalData can be created from raw values.
     */
    public function it_can_be_created_from_raw_values()
    {
        $this->beConstructedThrough('fromRawValues', [
            '31',
            ['33', '39', '41', '124'],
        ]);

        $this->shouldBeAnInstanceOf(StationExternalData::class);
    }

    /**
     * Test that a StationExternalData can not be created with an empty external station id.
     */
    public function it_can_not_be_created_with_empty_external_station_id()
    {
        $this->beConstructedThrough('fromRawValues', [
            '',
            ['33', '39', '41', '124'],
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }
}
