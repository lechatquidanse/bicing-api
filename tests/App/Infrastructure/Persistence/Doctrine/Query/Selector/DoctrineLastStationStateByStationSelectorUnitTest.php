<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query\Selector;

use PHPUnit\Framework\TestCase;

final class DoctrineLastStationStateByStationSelectorUnitTest extends TestCase
{
    /** @test */
    public function it_contains_all_expected_field_selector(): void
    {
        $this->assertEquals([
            'IDENTITY(ss.stationAssigned) as station_id',
            'ss.statedAt as stated_at',
            'ss.availableBikeNumber as available_bike_number',
            'ss.availableSlotNumber as available_slot_number',
            'ss.status as status',
        ], DoctrineLastStationStateByStationSelector::select('ss'));
    }
}
