<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Factory;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Infrastructure\Factory\CreateStationCommandFactory;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Tests\App\Infrastructure\System\MockClock;
use Tests\Support\Builder\AvailabilityStationBuilder;
use Tests\Support\Builder\StationDetailTypeBuilder;
use Tests\Support\TestCase\IntegrationTestCase;

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
    public function it_can_create_from_availability_station_with_valid_data()
    {
        $createdAt = new \DateTimeImmutable();
        $expected  = new CreateStationCommand();

        $expected->name                     = '02 - C/ ROGER DE FLOR, 126';
        $expected->type                     = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $expected->externalStationId        = '2';
        $expected->nearByExternalStationIds = ['360', '368', '387', '414'];
        $expected->address                  = 'Roger de Flor/ Gran Vía';
        $expected->addressNumber            = '126';
        $expected->districtCode             = 2;
        $expected->zipCode                  = '08010';
        $expected->latitude                 = 41.39553;
        $expected->longitude                = 2.17706;
        $expected->createdAt                = $createdAt;

        $this->clock::willReturnDateTimeImmutable($createdAt);

        $this->assertEquals($expected, $this->factory->fromAvailabilityStation(
            AvailabilityStationBuilder::create()
                ->withName('02 - C/ ROGER DE FLOR, 126')
                ->withType('BIKE')
                ->withId('2')
                ->withNearByStationIds(['360', '368', '387', '414'])
                ->withAddress('Roger de Flor/ Gran Vía')
                ->withAddressNumber('126')
                ->withDistrictCode(2)
                ->withZipCode('08010')
                ->withLatitude(41.39553)
                ->withLongitude(2.17706)
                ->build()
        ));

        $this->clock::reset();
    }

    /**
     * @test
     */
    public function it_can_not_create_from_availability_station_with_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form invalid when creating CreateStationCommand.');

        $this->factory->fromAvailabilityStation(AvailabilityStationBuilder::create()
            ->withType('invalid type')
            ->build()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clock   = $this->getContainer()->get('test.app.system.clock.mock');
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
