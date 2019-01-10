<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use JMS\Serializer\Annotation as Serializer;

final class ApiResponse
{
    /**
     * @Serializer\Type("array<App\Infrastructure\BicingApi\AvailabilityStation>")
     *
     * @var array
     */
    private $stations = [];

    /**
     * @return array
     */
    public function stations(): array
    {
        return $this->stations;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return count($this->stations) > 0;
    }
}
