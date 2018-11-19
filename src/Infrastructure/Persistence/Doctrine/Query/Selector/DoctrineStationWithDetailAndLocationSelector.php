<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query\Selector;

final class DoctrineStationWithDetailAndLocationSelector
{
    public const FIELD_SELECTOR = [
        's.stationId as station_id',
        's.stationDetail.name as name',
        's.stationDetail.type as type',
        's.location.address as address',
        's.location.addressNumber as address_number',
        's.location.zipCode as zip_code',
        's.location.latitude as latitude',
        's.location.longitude as longitude',
    ];
}
