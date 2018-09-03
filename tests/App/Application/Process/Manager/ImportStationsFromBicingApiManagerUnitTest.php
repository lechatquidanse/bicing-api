<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use App\Application\Process\Manager\ImportStationsFromBicingApiManager;
use App\Application\UseCase\Command\CreateStationCommand;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpKernel\Tests\Logger;

class ImportStationsFromBicingApiManagerUnitTest extends TestCase
{
    /**
     * @var ImportStationsFromBicingApiManager
     */
    private $manager;

    /**
     * @var FakeAvailabilityStationQuery
     */
    private $query;

    /**
     * @var FakeCreateStationCommandFactory
     */
    private $factory;

    /**
     * @var SpyCommandBus
     */
    private $commandBus;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @test
     */
    public function it_can_manage_a_create_station_command_with_expected_date()
    {
        $this->manager->__invoke();

        $commands = $this->commandBus->commands();
        $command = array_pop($commands);

        $this->assertInstanceOf(CreateStationCommand::class, $command);
        $this->assertInstanceOf(UuidInterface::class, $command->stationId);
    }

    /**
     * @test
     */
    public function it_can_manage_two_stations_threw_command_bus()
    {
        $this->manager->__invoke();

        $this->assertCount(2, $this->commandBus->commands());
    }

    /**
     * @test
     */
    public function it_can_manage_two_errors_by_logging_with_error_level()
    {
        $this->commandBus::willThrowAnException();

        $this->manager->__invoke();

        $this->commandBus::reset();
        $this->assertCount(2, $this->logger->getLogs('error'));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->query = new FakeAvailabilityStationQuery();
        $this->factory = new FakeCreateStationCommandFactory();
        $this->commandBus = new SpyCommandBus();
        $this->logger = new Logger();

        $this->manager = new ImportStationsFromBicingApiManager(
            $this->query,
            $this->factory,
            $this->commandBus,
            $this->logger
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->manager = null;
        $this->commandBus = null;
        $this->factory = null;
        $this->query = null;

        parent::tearDown();
    }
}
