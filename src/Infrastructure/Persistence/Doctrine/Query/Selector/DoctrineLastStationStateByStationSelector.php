<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query\Selector;

final class DoctrineLastStationStateByStationSelector
{
    private const FIELD_SELECTOR = [
        'IDENTITY(%alias%.stationAssigned) as station_id',
        '%alias%.statedAt as stated_at',
        '%alias%.availableBikeNumber as available_bike_number',
        '%alias%.availableSlotNumber as available_slot_number',
        '%alias%.status as status',
    ];

    /**
     * @param string $alias
     *
     * @return array
     */
    public static function select(string $alias): array
    {
        return str_replace('%alias%', $alias, self::FIELD_SELECTOR);
    }
}
