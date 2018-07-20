<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\Station;

use App\Domain\Exception\Station\StationDetailTypeIsInvalidException;
use App\Domain\Model\Station\StationDetailType;
use PhpSpec\ObjectBehavior;

/**
 * @see StationDetailType
 */
class StationDetailTypeSpec extends ObjectBehavior
{
    /**
     * Test that StationDetailType can be created with type BIKE.
     */
    public function it_can_be_created_from_string_bike()
    {
        $this->beConstructedThrough('fromString', ['BIKE']);

        $this->shouldBeAnInstanceOf(StationDetailType::class);
        $this->__toString()->shouldBe('BIKE');
    }

    /**
     * Test that StationDetailType can be created with type ELECTRIC_BIKE.
     */
    public function it_can_be_created_from_string_electric_bike()
    {
        $this->beConstructedThrough('fromString', ['ELECTRIC_BIKE']);

        $this->shouldBeAnInstanceOf(StationDetailType::class);
        $this->__toString()->shouldBe('ELECTRIC_BIKE');
    }

    /**
     * Test that a StationDetailType can not be created with invalid type.
     */
    public function it_can_not_be_created_from_string_with_invalid_string()
    {
        $this->beConstructedThrough('fromString', ['Invalid type']);

        $this->shouldThrow(StationDetailTypeIsInvalidException::class)->duringInstantiation();
    }
}
