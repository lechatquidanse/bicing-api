<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Filter;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use PHPUnit\Framework\TestCase;

/**
 * @see ByIntervalInPeriodFilter
 */
final class ByIntervalInPeriodFilterUnitTest extends TestCase
{
    /** @test */
    public function it_can_access_all_its_properties_to_getter(): void
    {
        $filter = ByIntervalInPeriodFilter::fromRawStringValues(
            '2016-08-12 15:54:00',
            '2016-12-12 05:35:12',
            '10 minutes'
        );

        $this->assertEquals(new \DateTime('2016-08-12 15:54:00'), $filter->getPeriodStart());
        $this->assertEquals(new \DateTime('2016-12-12 05:35:12'), $filter->getPeriodEnd());
        $this->assertEquals('10 minutes', $filter->getInterval());
    }
}
