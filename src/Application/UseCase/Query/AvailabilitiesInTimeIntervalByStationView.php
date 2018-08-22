<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

final class AvailabilitiesInTimeIntervalByStationView
{
    /** @var array */
    public $availabilities;

    /**
     * @param array $availabilities
     */
    public function __construct(array $availabilities)
    {
        $this->availabilities = $availabilities;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->availabilities;
    }
}
