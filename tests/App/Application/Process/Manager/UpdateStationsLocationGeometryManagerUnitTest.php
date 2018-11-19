<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use App\Application\Process\Manager\UpdateStationsLocationGeometryManager;
use App\Application\UseCase\Command\UpdateStationLocationGeometryCommand;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationBuilder;

class UpdateStationsLocationGeometryManagerUnitTest extends TestCase
{
    /** @var UpdateStationsLocationGeometryManager */
    private $manager;

    /** @var MockStationRepository */
    private $repository;

    /** @var SpyCommandBus */
    private $commandBus;

    /**
     * @test
     */
    public function it_can_manage_two_stations_threw_command_bus(): void
    {
        $stationId1 = Uuid::uuid4();
        $stationId2 = Uuid::uuid4();

        $this->repository->add(StationBuilder::create()->withStationId($stationId1)->build());
        $this->repository->add(StationBuilder::create()->withStationId($stationId2)->build());

        $this->manager->__invoke();

        $commands = $this->commandBus->commands();

        $this->assertCount(2, $commands);
        $this->assertInstanceOf(UpdateStationLocationGeometryCommand::class, $commands[0]);
        $this->assertEquals($stationId1, ($commands[0])->stationId());
        $this->assertInstanceOf(UpdateStationLocationGeometryCommand::class, $commands[1]);
        $this->assertEquals($stationId2, ($commands[1])->stationId());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = new MockStationRepository();
        $this->commandBus = new SpyCommandBus();

        $this->manager = new UpdateStationsLocationGeometryManager($this->repository, $this->commandBus);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->manager = null;
        $this->commandBus = null;
        $this->repository = null;

        parent::tearDown();
    }
}
