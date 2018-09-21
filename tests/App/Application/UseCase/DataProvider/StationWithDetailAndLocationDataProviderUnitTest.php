<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\DataProvider;

use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Application\UseCase\DataProvider\StationWithDetailAndLocationDataProvider;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
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

    /** @test */
    public function it_can_not_get_item_with_a_not_supported_class(): void
    {
        $this->expectException(ResourceClassNotSupportedException::class);
        $this->expectExceptionMessage(
            'Resource Class supported_class_name not supported by Station List DataProvider'
        );

        $this->provider->getItem('supported_class_name', Uuid::uuid4());
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
