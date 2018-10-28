<?php

declare(strict_types=1);

namespace tests\App\Domain\Model\StationState;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use PHPUnit\Framework\TestCase;

/**
 * @see DateTimeImmutableStringable
 */
class DateTimeImmutableStringableUnitTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_displayed_as_a_string_in_specific_format_by_default(): void
    {
        $time = '1998-07-13 22:30:21';
        $date = DateTimeImmutableStringable::fromDateTimeImmutable(new \DateTimeImmutable($time));

        $this->assertEquals($time, $date);
    }
}
