<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\DataProvider;

use App\Application\UseCase\DataProvider\StationWithDetailAndLocationCollectionDataProvider;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use tests\Support\Builder\StationDetailTypeBuilder;

class StationWithDetailAndLocationCollectionDataProviderUnitTest extends TestCase
{
    /** @var StationWithDetailAndLocationCollectionDataProvider */
    private $provider;

    /** @var MockStationWithDetailAndLocationQuery */
    private $query;

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

        $generators = $this->provider->getCollection();

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
        $this->provider = new StationWithDetailAndLocationCollectionDataProvider($this->query);
    }

    protected function tearDown()
    {
        $this->provider = null;
        $this->query = null;

        parent::tearDown();
    }
}
