<?php

declare(strict_types=1);

namespace App\Application\Process\Manager;

use App\Application\UseCase\Command\AssignStationStateToStationCommandFactoryInterface;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\BicingApi\AvailabilityStationQueryInterface;
use App\Infrastructure\System\ClockInterface;
use Psr\Log\LoggerInterface;
use SimpleBus\Message\Bus\MessageBus;

final class ImportStationStatesFromBicingApiManager
{
    /**
     * @var AvailabilityStationQueryInterface
     */
    private $query;

    /**
     * @var AssignStationStateToStationCommandFactoryInterface
     */
    private $commandFactory;

    /**
     * @var MessageBus
     */
    private $commandBus;

    /**
     * @var ClockInterface
     */
    private $clock;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param AvailabilityStationQueryInterface                  $query
     * @param AssignStationStateToStationCommandFactoryInterface $commandFactory
     * @param MessageBus                                         $commandBus
     * @param ClockInterface                                     $clock
     * @param LoggerInterface                                    $logger
     */
    public function __construct(
        AvailabilityStationQueryInterface $query,
        AssignStationStateToStationCommandFactoryInterface $commandFactory,
        MessageBus $commandBus,
        ClockInterface $clock,
        LoggerInterface $logger)
    {
        $this->query = $query;
        $this->commandFactory = $commandFactory;
        $this->commandBus = $commandBus;
        $this->clock = $clock;
        $this->logger = $logger;
    }

    public function __invoke(): void
    {
        $statedAt = $this->clock->dateTimeImmutableStringable();
        $availabilityStations = $this->query->findAll();

        foreach ($availabilityStations as $availabilityStation) {
            $this->import($availabilityStation, $statedAt);
        }
    }

    /**
     * @param AvailabilityStation         $availabilityStation
     * @param DateTimeImmutableStringable $statedAt
     */
    private function import(AvailabilityStation $availabilityStation, DateTimeImmutableStringable $statedAt): void
    {
        try {
            $command = $this->commandFactory->fromAvailabilityStation($availabilityStation);

            $command->statedAt = $statedAt;

            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
