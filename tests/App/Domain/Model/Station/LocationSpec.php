<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\Station;

use App\Domain\Model\Station\Location;
use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use PhpSpec\ObjectBehavior;

/**
 * @see Location
 */
class LocationSpec extends ObjectBehavior
{
    /**
     * Test that Location can be created from raw values.
     */
    public function it_can_be_created_from_raw_values()
    {
        $this->beConstructedThrough('fromRawValues', [
            'Plaça del Mar',
            1,
            '08003',
            41.37481,
            2.18895,
        ]);

        $this->shouldBeAnInstanceOf(Location::class);
    }

    /**
     * Test that a Location can not be created with an empty address.
     */
    public function it_can_not_be_created_with_empty_address()
    {
        $this->beConstructedThrough('fromRawValues', [
            '',
            1,
            '08003',
            41.37481,
            2.18895,
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a Location can not be created with district code bigger than 10.
     */
    public function it_can_not_be_created_with_district_code_too_big()
    {
        $this->beConstructedThrough('fromRawValues', [
            'Plaça del Mar',
            11,
            '08003',
            41.37481,
            2.18895,
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a Location can not be created with a zip code length different than 5.
     */
    public function it_can_not_be_created_with_invalid_zip_code_length()
    {
        $this->beConstructedThrough('fromRawValues', [
            'Plaça del Mar',
            1,
            'invalid length code',
            41.37481,
            2.18895,
        ]);


        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a Location can not be specified with an address number longer than 11 characters.
     */
    public function it_can_not_be_specified_with_an_address_number_too_long()
    {
        $this->beConstructedThrough('fromRawValues', [
            'Plaça del Mar',
            1,
            '08003',
            41.37481,
            2.18895,
        ]);

        $this->shouldThrow(InvalidArgumentException::class)->duringWithAddressNumber('12345678900');
    }
}
