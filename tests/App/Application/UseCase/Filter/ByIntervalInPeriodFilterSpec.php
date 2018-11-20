<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Filter;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use Assert\LazyAssertionException;
use PhpSpec\ObjectBehavior;

/**
 * @see ByIntervalInPeriodFilter
 */
class ByIntervalInPeriodFilterSpec extends ObjectBehavior
{
    /**
     * Test that ByIntervalInPeriodFilter can be created from raw string values.
     */
    public function it_can_be_created_from_raw_string_values(): void
    {
        $this->beConstructedThrough('fromRawStringValues', [
            '2016-08-24 08:45:21',
            '2018-12-01 16:25:31',
            '5 minute',
        ]);

        $this->shouldBeAnInstanceOf(ByIntervalInPeriodFilter::class);
    }

    /**
     * Test that a ByIntervalInPeriodFilter can not be created with a periodStart invalid to create a DateTIme.
     */
    public function it_can_not_be_created_with_an_invalid_period_start(): void
    {
        $this->beConstructedThrough('fromRawStringValues', [
            'invalid_date_time_period_start',
            '2018-12-01 16:25:31',
            '5 minute',
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a ByIntervalInPeriodFilter can not be created with a periodEnd invalid to create a DateTIme.
     */
    public function it_can_not_be_created_with_an_invalid_period_end(): void
    {
        $this->beConstructedThrough('fromRawStringValues', [
            '2018-12-01 16:25:31',
            'invalid_date_time_period_end',
            '5 minute',
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a ByIntervalInPeriodFilter can not be created with an interval invalid, that does not respect the expected regex.
     */
    public function it_can_not_be_created_with_an_invalid_interval(): void
    {
        $this->beConstructedThrough('fromRawStringValues', [
            '2016-08-24 08:45:21',
            '2018-12-01 16:25:31',
            'invalid_interval',
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }

    /**
     * Test that a ByIntervalInPeriodFilter can not be created with an interval invalid, that does not respect the expected regex.
     */
    public function it_can_not_be_created_with_a_period_start_greater_than_period_end(): void
    {
        $this->beConstructedThrough('fromRawStringValues', [
            '2016-08-24 08:45:21',
            '1998-12-01 16:25:31',
            '5 minute',
        ]);

        $this->shouldThrow(LazyAssertionException::class)->duringInstantiation();
    }
}
