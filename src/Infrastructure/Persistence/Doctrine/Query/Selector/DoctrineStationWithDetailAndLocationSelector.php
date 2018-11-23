<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query\Selector;

final class DoctrineStationWithDetailAndLocationSelector
{
    private const FIELD_SELECTOR = [
        '%alias%.stationId as station_id',
        '%alias%.stationDetail.name as name',
        '%alias%.stationDetail.type as type',
        '%alias%.location.address as address',
        '%alias%.location.addressNumber as address_number',
        '%alias%.location.zipCode as zip_code',
        '%alias%.location.latitude as latitude',
        '%alias%.location.longitude as longitude',
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
