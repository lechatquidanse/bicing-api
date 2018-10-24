<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use App\Application\Process\Manager\ImportStationStatesFromBicingApiManager;
use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Application\UseCase\Command\RefreshLastStationStateByStationCacheCommand;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Tests\Logger;
use tests\App\Infrastructure\System\MockClock;

class ImportStationStatesFromBicingApiManagerUnitTest extends TestCase
{
    /**
     * @var ImportStationStatesFromBicingApiManager
     */
    private $manager;

    /**
     * @var FakeAvailabilityStationQuery
     */
    private $query;

    /**
     * @var FakeAssignStationStateToStationCommandFactory
     */
    private $factory;

    /**
     * @var SpyCommandBus
     */
    private $commandBus;

    /**
     * @var MockClock
     */
    private $clock;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @test
     */
    public function it_can_manage_an_assign_station_states_to_station_command_with_expected_date_and_refresh_cache_()
    {
        $statedAt = new DateTimeImmutableStringable();

        $this->clock::willReturnDateTimeImmutableStringable($statedAt);

        $this->manager->__invoke();

        $this->clock::reset();

        $commands = $this->commandBus->commands();

        $this->assertInstanceOf(RefreshLastStationStateByStationCacheCommand::class, array_pop($commands));

        $command = array_pop($commands);

        $this->assertInstanceOf(AssignStationStateToStationCommand::class, $command);
        $this->assertEquals($statedAt, $command->statedAt);
    }

    /**
     * @test
     */
    public function it_can_manage_two_station_states_threw_command_bus()
    {
        $this->manager->__invoke();
        $commands = $this->commandBus->commands();

        $this->assertInstanceOf(RefreshLastStationStateByStationCacheCommand::class, array_pop($commands));

        $this->assertCount(2, $commands);
    }

    /**
     * @test
     */
    public function it_can_manage_two_errors_by_logging_with_error_level()
    {
        $this->commandBus::willThrowAnException();

        $this->manager->__invoke();

        $this->commandBus::reset();

        $this->assertCount(3, $this->logger->getLogs('error'));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->query = new FakeAvailabilityStationQuery();
        $this->factory = new FakeAssignStationStateToStationCommandFactory();
        $this->commandBus = new SpyCommandBus();
        $this->clock = new MockClock();
        $this->logger = new Logger();

        $this->manager = new ImportStationStatesFromBicingApiManager(
            $this->query,
            $this->factory,
            $this->commandBus,
            $this->clock,
            $this->logger
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->manager = null;
        $this->clock = null;
        $this->commandBus = null;
        $this->factory = null;
        $this->query = null;

        parent::tearDown();
    }
}
