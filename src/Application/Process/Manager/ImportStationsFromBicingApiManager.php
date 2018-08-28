<?php

declare(strict_types=1);

namespace App\Application\Process\Manager;

use App\Application\UseCase\Command\CreateStationCommandFactoryInterface;
use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\BicingApi\AvailabilityStationQueryInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use SimpleBus\Message\Bus\MessageBus;

final class ImportStationsFromBicingApiManager
{
    /**
     * @var AvailabilityStationQueryInterface
     */
    private $query;

    /**
     * @var CreateStationCommandFactoryInterface
     */
    private $commandFactory;

    /**
     * @var MessageBus
     */
    private $commandBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param AvailabilityStationQueryInterface    $query
     * @param CreateStationCommandFactoryInterface $commandFactory
     * @param MessageBus                           $commandBus
     * @param LoggerInterface                      $logger
     */
    public function __construct(
        AvailabilityStationQueryInterface $query,
        CreateStationCommandFactoryInterface $commandFactory,
        MessageBus $commandBus,
        LoggerInterface $logger)
    {
        $this->query = $query;
        $this->commandFactory = $commandFactory;
        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }

    public function __invoke(): void
    {
        $availabilityStations = $this->query->findAll();

        foreach ($availabilityStations as $availabilityStation) {
            $this->import($availabilityStation);
        }
    }

    /**
     * @param AvailabilityStation $availabilityStation
     */
    private function import(AvailabilityStation $availabilityStation): void
    {
        try {
            $command = $this->commandFactory->fromAvailabilityStation($availabilityStation);

            $command->stationId = Uuid::uuid4();

            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
