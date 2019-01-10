<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\BicingApi\HttpAvailabilityStationQuery;
use tests\Support\Builder\BicingApi\AvailabilityBuilder;
use tests\Support\Builder\BicingApi\AvailabilityStationBuilder;
use tests\Support\Builder\BicingApi\LocationBuilder;
use tests\Support\Builder\BicingApi\StationBuilder;
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
            AvailabilityStationBuilder::create()
                ->withId('406')
                ->withAvailability(AvailabilityBuilder::create()
                    ->withStatus('OPENED')
                    ->withBikes(30)
                    ->withSlots(1)
                    ->build())
                ->withStation(StationBuilder::create()
                    ->withName('Gran Via de Les Corts Catalanes')
                    ->withType('ELECTRIC_BIKE')
                    ->build())
                ->withLocation(LocationBuilder::create()
                    ->withLongitude(2.164597)
                    ->withLatitude(41.386512)
                    ->withAddress('Gran Via de Les Corts Catalanes')
                    ->withAddressNumber('592')
                    ->build())
                ->build(),
            AvailabilityStationBuilder::create()
                ->withId('405')
                ->withAvailability(AvailabilityBuilder::create()
                    ->withStatus('CLOSED')
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
                ->build(),
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
