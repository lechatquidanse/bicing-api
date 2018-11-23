<?php

declare(strict_types=1);

namespace App\Application\UseCase\Handler;

use App\Application\UseCase\Command\UpdateStationLocationGeometryCommand;

final class UpdateStationLocationGeometryHandler
{
    /** @var UpdateStationLocationGeometryStatementInterface */
    private $statement;

    /**
     * @param UpdateStationLocationGeometryStatementInterface $statement
     */
    public function __construct(UpdateStationLocationGeometryStatementInterface $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @param UpdateStationLocationGeometryCommand $command
     */
    public function __invoke(UpdateStationLocationGeometryCommand $command)
    {
        $this->statement->execute($command->stationId());
    }
}
