<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Infrastructure\Persistence\Doctrine\Query\DoctrineStationWithDetailAndLocationQuery;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\LocationBuilder;
use tests\Support\Builder\StationBuilder;
use tests\Support\Builder\StationDetailBuilder;
use tests\Support\Builder\StationDetailTypeBuilder;
use tests\Support\TestCase\DatabaseTestCase;

class DoctrineStationWithDetailAndLocationQueryIntegrationTest extends DatabaseTestCase
{
    /** @var DoctrineStationWithDetailAndLocationQuery */
    private $query;

    /**
     * @test
     */
    public function it_can_find_a_station(): void
    {
        $stationId = Uuid::uuid4();
        $type = StationDetailTypeBuilder::create()->withTypeBike()->build();

        $this->buildPersisted(StationBuilder::create()
            ->withStationId($stationId)
            ->withStationDetail(StationDetailBuilder::create()
                ->withType($type)
                ->withName('08 - PG. PUJADES 2')
                ->build())
            ->withLocation(LocationBuilder::create()
                ->withAddress('Pg Lluis Companys')
                ->withAddressNumber('23')
                ->withZipCode('08024')
                ->withLatitude(41.389088)
                ->withLongitude(2.183568)
                ->build()));

        $this->assertEquals([
            'station_id' => $stationId,
            'name' => '08 - PG. PUJADES 2',
            'type' => $type,
            'address' => 'Pg Lluis Companys',
            'address_number' => '23',
            'zip_code' => '08024',
            'latitude' => 41.389088,
            'longitude' => 2.183568,
        ], $this->query->find($stationId));
    }

    /**
     * @test
     */
    public function it_can_not_find_a_station_that_does_not_exist(): void
    {
        $stationId = Uuid::uuid4();

        $this->buildPersisted(StationBuilder::create()
            ->withStationId($stationId));

        $this->assertNull($this->query->find(Uuid::uuid4()));
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->query = $this->getContainer()->get('test.app.query.station_with_detail_and_location_query');
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->query = null;

        parent::tearDown();
    }
}
