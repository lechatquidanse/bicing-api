<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Handler;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Application\UseCase\Handler\AssignStationStateToStationHandler;
use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationStateStatus;
use PHPUnit\Framework\TestCase;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationExternalDataBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;

class AssignStationStateToStationHandlerUnitTest extends TestCase
{
    /**
     * @var AssignStationStateToStationHandler
     */
    private $handler;

    /**
     * @var MockStationRepository
     */
    private $stationRepository;

    /**
     * @var MockStationStateRepository
     */
    private $stationStateRepository;

    /**
     * Test that handle a assign station state command will store the expected data in a station state repository.
     *
     * @test
     */
    public function it_can_handle()
    {
        $statedAt = new DateTimeImmutableStringable();
        $createdAt = new \DateTimeImmutable();

        $station = StationBuilder::create()
            ->withStationExternalData(StationExternalDataBuilder::create()
                ->withExternalStationId('23')
                ->build())
            ->build();

        $this->stationRepository->add($station);

        $this->handler->__invoke($this->command(
            $statedAt,
            '23',
            5,
            15,
            StationStateStatusBuilder::create()->build(),
            $createdAt
        ));

        $this->assertEquals(StationStateBuilder::create()
            ->withStatedAt($statedAt)
            ->withStationAssigned($station)
            ->withAvailableBikeNumber(5)
            ->withAvailableSlotNumber(15)
            ->withCreatedAt($createdAt)
            ->build(), $this->stationStateRepository->find($statedAt, $station));
    }

    /**
     * @test
     */
    public function it_can_not_handle_a_station_that_does_not_exist()
    {
        $this->expectException(StationDoesNotExist::class);
        $this->expectExceptionMessage('A station does not exist with external station Id "1".');

        $this->handler->__invoke($this->command(
            new DateTimeImmutableStringable(),
            '1',
            5,
            15,
            StationStateStatusBuilder::create()->build(),
            new \DateTimeImmutable()
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->stationRepository = new MockStationRepository();
        $this->stationStateRepository = new MockStationStateRepository();
        $this->handler = new AssignStationStateToStationHandler(
            $this->stationRepository,
            $this->stationStateRepository
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->handler = null;
        $this->stationRepository = null;
        $this->stationStateRepository = null;

        parent::tearDown();
    }

    private function command(
        DateTimeImmutableStringable $statedAt,
        string $externalStationId,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status,
        \DateTimeImmutable $createdAt
    ): AssignStationStateToStationCommand {
        $command = new AssignStationStateToStationCommand();

        $command->statedAt = $statedAt;
        $command->externalStationId = $externalStationId;
        $command->availableBikeNumber = $availableBikeNumber;
        $command->availableSlotNumber = $availableSlotNumber;
        $command->status = $status;
        $command->createdAt = $createdAt;

        return $command;
    }
}
