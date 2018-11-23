<?php

declare(strict_types=1);

namespace App\Application\UseCase\Handler;

use Ramsey\Uuid\UuidInterface;

interface UpdateStationLocationGeometryStatementInterface
{
    public function execute(UuidInterface $stationId);
}
