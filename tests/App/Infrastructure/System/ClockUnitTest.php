<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\System;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\System\Clock;
use PHPUnit\Framework\TestCase;

class ClockUnitTest extends TestCase
{
    /** @var Clock */
    private $clock;

    /** @test */
    public function it_can_return_a_date_time_immutable_from_a_string(): void
    {
        $time = '2016-08-01 12:43:41';

        $this->assertEquals(
            new \DateTimeImmutable($time),
            $this->clock->dateTimeImmutable($time)
        );
    }

    /** @test */
    public function it_can_return_a_date_time_immutable_stringable_from_a_string(): void
    {
        $time = '2008-02-23 16:03:12';

        $this->assertEquals(
            new DateTimeImmutableStringable($time),
            $this->clock->dateTimeImmutableStringable($time)
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->clock = new Clock();
    }

    protected function tearDown()
    {
        $this->clock = null;

        parent::tearDown();
    }
}
