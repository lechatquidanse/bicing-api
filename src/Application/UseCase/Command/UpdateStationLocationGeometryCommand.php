<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use Ramsey\Uuid\UuidInterface;

final class UpdateStationLocationGeometryCommand
{
    /** @var UuidInterface */
    private $stationId;

    /**
     * @param UuidInterface $stationId
     */
    private function __construct(UuidInterface $stationId)
    {
        $this->stationId = $stationId;
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return UpdateStationLocationGeometryCommand
     */
    public static function create(UuidInterface $stationId): UpdateStationLocationGeometryCommand
    {
        return new self($stationId);
    }

    /**
     * @return UuidInterface
     */
    public function stationId(): UuidInterface
    {
        return $this->stationId;
    }
}
