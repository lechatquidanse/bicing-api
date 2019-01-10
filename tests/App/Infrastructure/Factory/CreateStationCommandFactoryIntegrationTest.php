<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Factory;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Infrastructure\Factory\CreateStationCommandFactory;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use tests\App\Infrastructure\System\MockClock;
use tests\Support\Builder\BicingApi\AvailabilityStationBuilder;
use tests\Support\Builder\BicingApi\LocationBuilder;
use tests\Support\Builder\BicingApi\StationBuilder;
use tests\Support\Builder\StationDetailTypeBuilder;
use tests\Support\TestCase\IntegrationTestCase;

class CreateStationCommandFactoryIntegrationTest extends IntegrationTestCase
{
    /**
     * @var CreateStationCommandFactory
     */
    private $factory;

    /**
     * @var MockClock
     */
    private $clock;

    /**
     * @test
     */
    public function it_can_create_from_availability_station_with_valid_data(): void
    {
        $createdAt = new \DateTimeImmutable();
        $expected = new CreateStationCommand();

        $expected->name = '02 - C/ ROGER DE FLOR, 126';
        $expected->type = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $expected->externalStationId = '2';
        $expected->nearByExternalStationIds = ['360', '368', '387', '414'];
        $expected->address = 'Roger de Flor/ Gran Vía';
        $expected->addressNumber = '126';
        $expected->districtCode = 2;
        $expected->zipCode = '08010';
        $expected->latitude = 41.39553;
        $expected->longitude = 2.17706;
        $expected->createdAt = $createdAt;

        $this->clock::willReturnDateTimeImmutable($createdAt);

        $this->assertEquals($expected, $this->factory->fromAvailabilityStation(
            AvailabilityStationBuilder::create()
                ->withId('2')
                ->withStation(StationBuilder::create()
                    ->withName('02 - C/ ROGER DE FLOR, 126')
                    ->withType('BIKE')
                    ->withNearByStationIds(['360', '368', '387', '414'])
                    ->build())
                ->withLocation(LocationBuilder::create()
                    ->withLongitude(2.17706)
                    ->withLatitude(41.39553)
                    ->withAddress('Roger de Flor/ Gran Vía')
                    ->withAddressNumber('126')
                    ->withDistrictCode(2)
                    ->withZipCode('08010')
                    ->build())
                ->build()
        ));

        $this->clock::reset();
    }

    /**
     * @test
     */
    public function it_can_create_from_availability_station_with_required_valid_data(): void
    {
        $createdAt = new \DateTimeImmutable();
        $expected = new CreateStationCommand();

        $expected->name = '02 - C/ ROGER DE FLOR, 126';
        $expected->type = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $expected->externalStationId = '2';
        $expected->address = 'Roger de Flor/ Gran Vía';
        $expected->addressNumber = '126';
        $expected->latitude = 41.39553;
        $expected->longitude = 2.17706;
        $expected->createdAt = $createdAt;
        $expected->nearByExternalStationIds = [];

        $this->clock::willReturnDateTimeImmutable($createdAt);

        $this->assertEquals($expected, $this->factory->fromAvailabilityStation(
            AvailabilityStationBuilder::create()
                ->withId('2')
                ->withStation(StationBuilder::create()
                    ->withName('02 - C/ ROGER DE FLOR, 126')
                    ->withType('BIKE')
                    ->build())
                ->withLocation(LocationBuilder::create()
                    ->withLongitude(2.17706)
                    ->withLatitude(41.39553)
                    ->withAddress('Roger de Flor/ Gran Vía')
                    ->withAddressNumber('126')
                    ->build())
                ->build()
        ));

        $this->clock::reset();
    }

    /**
     * @test
     */
    public function it_can_not_create_from_availability_station_with_invalid_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form invalid when creating CreateStationCommand.');

        $this->factory->fromAvailabilityStation(
            AvailabilityStationBuilder::create()
                ->withStation(StationBuilder::create()
                    ->withType('invalid_type')
                    ->build())
                ->build()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clock = $this->getContainer()->get('test.app.system.clock.mock');
        $this->factory = $this->getContainer()->get('test.app.factory.create_station_command');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->factory = null;

        parent::tearDown();
    }
}
