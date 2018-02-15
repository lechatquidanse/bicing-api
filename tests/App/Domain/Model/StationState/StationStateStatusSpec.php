<?php

declare(strict_types=1);

namespace Tests\App\Domain\Model\StationState;

use App\Domain\Exception\StationState\StationStateStatusIsInvalidException;
use App\Domain\Model\StationState\StationStateStatus;
use PhpSpec\ObjectBehavior;


/**
 * @see StationStateStatus
 */
class StationStateStatusSpec extends ObjectBehavior
{
    /**
     * Test that StationStateStatus can be created with status OPENED
     */
    public function it_can_be_created_from_string_opened()
    {
        $this->beConstructedThrough('fromString', ['OPENED']);

        $this->shouldBeAnInstanceOf(StationStateStatus::class);
        $this->__toString()->shouldBe('OPENED');
    }

    /**
     * Test that StationStateStatus can be created with status OPN
     */
    public function it_can_be_created_from_string_opn()
    {
        $this->beConstructedThrough('fromString', ['OPN']);

        $this->shouldBeAnInstanceOf(StationStateStatus::class);
        $this->__toString()->shouldBe('OPENED');
    }

    /**
     * Test that StationStateStatus can be created with status CLOSED
     */
    public function it_can_be_created_from_string_closed()
    {
        $this->beConstructedThrough('fromString', ['CLOSED']);

        $this->shouldBeAnInstanceOf(StationStateStatus::class);
        $this->__toString()->shouldBe('CLOSED');
    }

    /**
     * Test that StationStateStatus can be created with status CLS
     */
    public function it_can_be_created_from_string_cls()
    {
        $this->beConstructedThrough('fromString', ['CLS']);

        $this->shouldBeAnInstanceOf(StationStateStatus::class);
        $this->__toString()->shouldBe('CLOSED');
    }

    /**
     * Test that a StationStateStatus can not be created with invalid status.
     */
    public function it_can_not_be_created_from_string_with_invalid_string()
    {
        $this->beConstructedThrough('fromString', ['Invalid status']);

        $this->shouldThrow(StationStateStatusIsInvalidException::class)->duringInstantiation();
    }
}
