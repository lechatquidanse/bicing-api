<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Handler;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Application\UseCase\Handler\CreateStationHandler;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\LocationBuilder;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationDetailBuilder;
use tests\Support\Builder\StationDetailTypeBuilder;
use tests\Support\Builder\StationExternalDataBuilder;

class CreateStationHandlerUnitTest extends TestCase
{
    /**
     * @var CreateStationHandler
     */
    private $handler;

    /**
     * @var MockStationRepository
     */
    private $repository;

    /**
     * Test that handle a create station command will store the expected data in a station repository.
     *
     * @test
     */
    public function it_can_handle()
    {
        $stationId = Uuid::uuid4();
        $createdAt = new \DateTimeImmutable();

        $command = new CreateStationCommand();

        $command->stationId = $stationId;
        $command->name = '19 - C/ ROSSELLÓ 354';
        $command->type = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $command->externalStationId = '20';
        $command->nearByExternalStationIds = ['21', '28', '164', '177', '278'];
        $command->address = 'Cartagena';
        $command->addressNumber = '308';
        $command->districtCode = 2;
        $command->zipCode = '08025';
        $command->latitude = 41.410166;
        $command->longitude = 2.175759;
        $command->createdAt = $createdAt;

        $this->handler->__invoke($command);

        $this->assertEquals(StationBuilder::create()
            ->withStationId($stationId)
            ->withStationDetail(StationDetailBuilder::create()
                ->withName('19 - C/ ROSSELLÓ 354')
                ->withType(StationDetailTypeBuilder::create()->withTypeBike()->build())
                ->build())
            ->withStationExternalData(StationExternalDataBuilder::create()
                ->withExternalStationId('20')
                ->withNearByExternalStationIds(['21', '28', '164', '177', '278'])
                ->build())
            ->withLocation(LocationBuilder::create()
                ->withAddress('Cartagena')
                ->withAddressNumber('308')
                ->withDistrictCode(2)
                ->withZipCode('08025')
                ->withLatitude(41.410166)
                ->withLongitude(2.175759)
                ->build())
            ->withCreatedAt($createdAt)
            ->build(), $this->repository->findByExternalStationId('20'));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = new MockStationRepository();
        $this->handler = new CreateStationHandler($this->repository);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->handler = null;
        $this->repository = null;

        parent::tearDown();
    }
}
