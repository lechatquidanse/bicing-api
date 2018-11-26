<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\BicingApi\HttpAvailabilityStationQuery;
use tests\Support\TestCase\IntegrationTestCase;

/**
 * @see HttpAvailabilityStationQuery
 */
class HttpAvailabilityStationQueryIntegrationTest extends IntegrationTestCase
{
    /**
     * @var HttpAvailabilityStationQuery
     */
    private $repository;

    /** @var MockHttpQueryClient */
    private $httpClient;

    /** @test */
    public function it_can_find_all_two_availability_stations(): void
    {
        $expected = [
            AvailabilityStation::create(
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
                'BIKE'
            ),
            AvailabilityStation::create(
                '2',
                2,
                2.17706,
                41.39553,
                16,
                11,
                '08010',
                'Roger de Flor/ Gran Vía',
                '126',
                ['360', '368', '387', '414'],
                'OPN',
                '02 - C/ ROGER DE FLOR, 126',
                'BIKE'
            ),
        ];

        $this->assertEquals($expected, $this->repository->findAll());
    }

    /** @test */
    public function it_can_not_find_if_empty_http_response_return(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('An error occurred during AvailabilityStation query deserialization ');

        $this->httpClient::willReturnEmptyResponse();
        $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->httpClient = $this->getContainer()->get('eight_points_guzzle.client.bicing_api');
        $this->repository = $this->getContainer()->get('test.app.bicing_api.availability_station_query');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->httpClient::reset();
        $this->httpClient = null;
        $this->repository = null;

        parent::tearDown();
    }
}
