<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Exception\StationState\StationStateAlreadyExistsException;
use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineStationStateRepository;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationStateBuilder;
use tests\Support\Builder\StationStateStatusBuilder;
use tests\Support\TestCase\DatabaseTestCase;

/**
 * @see DoctrineStationStateRepository
 */
class DoctrineStationStateRepositoryIntegrationTest extends DatabaseTestCase
{
    /**
     * @var DoctrineStationStateRepository
     */
    private $repository;

    /**
     * @test
     */
    public function it_can_add_a_station_state()
    {
        /** @var Station $station */
        $station = $this->buildPersisted(StationBuilder::create());
        $statedAt = new DateTimeImmutableStringable();

        $stationState = (StationStateBuilder::create())
            ->withStatedAt($statedAt)
            ->withStationAssigned($station)
            ->withAvailableBikeNumber(7)
            ->withAvailableSlotNumber(23)
            ->withStatus(StationStateStatusBuilder::create()->build())
            ->withCreatedAt(new \DateTimeImmutable())
            ->build();

        $this->repository->add($stationState);

        $this->assertEquals($stationState, $this->find(
            StationState::class,
            ['statedAt' => $statedAt, 'stationAssigned' => $station]
        ));
    }

    /**
     * @test
     */
    public function it_can_not_add_a_station_that_already_exists_with_same_statedAt_and_station()
    {
        $this->expectException(StationStateAlreadyExistsException::class);
        $this->expectExceptionMessage(
            'A station state already exists with stated at "2017-10-17 16:10:47" and station assigned Id "25769c6c-d34d-4bfe-ba98-e0ee856f3e7a".'
        );

        $stationId = Uuid::fromString('25769c6c-d34d-4bfe-ba98-e0ee856f3e7a');

        /** @var Station $station */
        $station = $this->buildPersisted(StationBuilder::create()->withStationId($stationId));
        $statedAt = (new DateTimeImmutableStringable())
            ->setDate(2017, 10, 17)
            ->setTime(16, 10, 47);

        $this->repository->add((StationStateBuilder::create())
            ->withStatedAt($statedAt)
            ->withStationAssigned($station)
            ->build());

        $this->repository->add((StationStateBuilder::create())
            ->withStatedAt($statedAt)
            ->withStationAssigned($station)
            ->build());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->repository = $this->getContainer()->get('test.app.model.station_state_repository');
    }

    protected function tearDown()
    {
        $this->repository = null;

        parent::tearDown();
    }
}
