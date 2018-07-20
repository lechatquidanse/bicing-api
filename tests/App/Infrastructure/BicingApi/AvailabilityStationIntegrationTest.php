<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\BicingApi\AvailabilityStation;
use JMS\Serializer\SerializerInterface;
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
    public function it_can_be_deserialized_from_json()
    {
        $expected = AvailabilityStation::create(
            '1',
            2,
            2.180042,
            41.397952,
            7,
            20,
            '08013',
            'Gran Via Corts Catalanes',
            '760',
            ['24', '369', '387', '426'],
            'OPN',
            '01 - C/ GRAN VIA CORTS CATALANES 760',
            'BIKE');

        $this->assertEquals($expected, $this->serializer->deserialize(
            <<<'json'
{
    "id": "1",
    "district": "2",
    "lon": "2.180042",
    "lat": "41.397952",
    "bikes": "7",
    "slots": "20",
    "zip": "08013",
    "address": "Gran Via Corts Catalanes",
    "addressNumber": "760",
    "nearbyStations": "24,369,387,426",
    "status": "OPN",
    "name": "01 - C/ GRAN VIA CORTS CATALANES 760",
    "stationType": "BIKE"
}
json
            ,
            AvailabilityStation::class,
            'json'));
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
