<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Query;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use App\Application\UseCase\Query\StationAvailabilitiesByIntervalInPeriodFilterView;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class StationAvailabilitiesByIntervalInPeriodFilterViewUnitTest extends TestCase
{
    /** @test */
    public function it_can_be_created(): void
    {
        $stationId = Uuid::uuid4();
        $availabilities = ['availability 1', 'availability 2'];
        $filter = ByIntervalInPeriodFilter::fromRawStringValues(
            '2016-08-03 17:02:34',
            '2016-08-04 17:02:34',
            '10 minutes'
        );

        $view = new StationAvailabilitiesByIntervalInPeriodFilterView(
            $stationId,
            $availabilities,
            $filter
        );

        $this->assertEquals($stationId, $view->stationId);
        $this->assertEquals($availabilities, $view->availabilities);
        $this->assertEquals($filter, $view->filter);
    }
}
