<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\BicingApi\AvailabilityStation;
use JMS\Serializer\SerializerInterface;
use tests\Support\Builder\BicingApi\AvailabilityStationBuilder;
use tests\Support\Builder\BicingApi\AvailabilityBuilder;
use tests\Support\Builder\BicingApi\LocationBuilder;
use tests\Support\Builder\BicingApi\StationBuilder;
use tests\Support\TestCase\IntegrationTestCase;

/**
 * @see AvailabilityStation
 */
class AvailabilityStationIntegrationTest extends IntegrationTestCase
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @test
     */
    public function it_can_be_deserialized_from_json(): void
    {
        $expected = AvailabilityStationBuilder::create()
            ->withId('405')
            ->withAvailability(AvailabilityBuilder::create()
                ->withStatus('OPENED')
                ->withBikes(1)
                ->withSlots(24)
            ->build())
            ->withStation(StationBuilder::create()
                ->withName('Comte Borrell')
                ->withType('BIKE')
            ->build())
            ->withLocation(LocationBuilder::create()
                ->withLongitude(2.152)
                ->withLatitude(41.38551)
                ->withAddress('Comte Borrell')
                ->withAddressNumber('198')
            ->build())
        ->build();

        $this->assertEquals($expected, $this->serializer->deserialize(
            <<<'json'
{
    "id": "405",
    "type": "BIKE",
    "latitude": "41.38551",
    "longitude": "2.152",
    "streetName": "Comte Borrell",
    "streetNumber": "198",
    "slots": "24",
    "bikes": "1",
    "type_bicing": 1,
    "electrical_bikes": 0,
    "mechanical_bikes": "0",
    "status": 1,
    "disponibilidad": 0,
    "icon": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio-0.png",
    "transition_start": "",
    "transition_end": ""
}
json
            ,
            AvailabilityStation::class,
            'json'
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->serializer = $this->getContainer()->get('jms_serializer');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->serializer = null;

        parent::tearDown();
    }
}
