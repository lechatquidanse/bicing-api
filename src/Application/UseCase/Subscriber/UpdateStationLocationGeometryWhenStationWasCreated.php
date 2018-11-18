<?php

declare(strict_types=1);

namespace App\Application\UseCase\Subscriber;

use App\Application\UseCase\Command\UpdateStationLocationGeometryCommand;
use App\Domain\Event\Station\StationWasCreated;
use SimpleBus\Message\Bus\MessageBus;

final class UpdateStationLocationGeometryWhenStationWasCreated
{
    /** @var MessageBus */
    private $commandBus;

    /**
     * @param MessageBus $commandBus
     */
    public function __construct(MessageBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param StationWasCreated $event
     */
    public function __invoke(StationWasCreated $event)
    {
        $this->commandBus->handle(UpdateStationLocationGeometryCommand::create($event->stationId()));
    }
}
