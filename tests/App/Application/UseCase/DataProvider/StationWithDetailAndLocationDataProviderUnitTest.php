<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\DataProvider;

use App\Application\UseCase\DataProvider\StationWithDetailAndLocationDataProvider;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationDetailTypeBuilder;

class StationWithDetailAndLocationDataProviderUnitTest extends TestCase
{
    /** @var StationWithDetailAndLocationDataProvider */
    private $provider;

    /** @var MockStationWithDetailAndLocationQuery */
    private $query;

    /** @test */
    public function it_can_get_an_item_that_does_exist(): void
    {
        $stationId = Uuid::uuid4();

        $this->query->addStationWithDetailAndLocation(
            $stationId,
            'Placa Catalunya',
            StationDetailTypeBuilder::create()->withTypeBike()->build(),
            'Pg Lluis Companys',
            '2',
            '08018',
            41.389088,
            2.183568
        );

        $this->assertEquals(StationWithDetailAndLocationView::fromArray([
            'station_id' => $stationId,
            'name' => 'Placa Catalunya',
            'type' => StationDetailTypeBuilder::create()->withTypeBike()->build(),
            'address' => 'Pg Lluis Companys',
            'address_number' => '2',
            'zip_code' => '08018',
            'latitude' => 41.389088,
            'longitude' => 2.183568,
        ]), $this->provider->getItem(StationWithDetailAndLocationView::class, $stationId));
    }

    /** @test */
    public function it_can_not_get_an_item_for_a_station_that_does_not_exist(): void
    {
        $this->expectException(StationDoesNotExist::class);
        $this->expectExceptionMessage(
            'A station does not exist with external station Id "50ca0f4c-a474-40e3-a1d0-8fd0901b46d3".'
        );

        $this->query->addStationWithDetailAndLocation(
            Uuid::uuid4(),
            'Placa Catalunya',
            StationDetailTypeBuilder::create()->withTypeBike()->build(),
            'Pg Lluis Companys',
            '2',
            '08018',
            41.389088,
            2.183568
        );

        $this->provider->getItem(
            StationWithDetailAndLocationView::class,
            Uuid::fromString('50ca0f4c-a474-40e3-a1d0-8fd0901b46d3')
        );
    }

    /** @test */
    public function it_can_get_a_collection_that_exists(): void
    {
        $stationId1 = Uuid::uuid4();
        $stationId2 = Uuid::uuid4();

        $this->query->addStationWithDetailAndLocation(
            $stationId1,
            'Placa Catalunya',
            StationDetailTypeBuilder::create()->withTypeBike()->build(),
            'Pg Lluis Companys',
            '2',
            '08018',
            41.389088,
            2.183568
        );

        $this->query->addStationWithDetailAndLocation(
            $stationId2,
            '492 - PL. TETUAN',
            StationDetailTypeBuilder::create()->withTypeElectricBike()->build(),
            'PL. DE TETUAN',
            '8-9',
            '08010',
            41.394232,
            2.175278
        );

        $generators = $this->provider->getCollection(StationWithDetailAndLocationView::class);

        $this->assertEquals(
            StationWithDetailAndLocationView::fromArray([
                'station_id' => $stationId1,
                'name' => 'Placa Catalunya',
                'type' => StationDetailTypeBuilder::create()->withTypeBike()->build(),
                'address' => 'Pg Lluis Companys',
                'address_number' => '2',
                'zip_code' => '08018',
                'latitude' => 41.389088,
                'longitude' => 2.183568,
            ]),
            $generators->current()
        );

        $generators->next();

        $this->assertEquals(
            StationWithDetailAndLocationView::fromArray([
                'station_id' => $stationId2,
                'name' => '492 - PL. TETUAN',
                'type' => StationDetailTypeBuilder::create()->withTypeElectricBike()->build(),
                'address' => 'PL. DE TETUAN',
                'address_number' => '8-9',
                'zip_code' => '08010',
                'latitude' => 41.394232,
                'longitude' => 2.175278,
            ]),
            $generators->current()
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->query = new MockStationWithDetailAndLocationQuery();
        $this->provider = new StationWithDetailAndLocationDataProvider($this->query);
    }

    protected function tearDown()
    {
        $this->provider = null;
        $this->query = null;

        parent::tearDown();
    }
}
