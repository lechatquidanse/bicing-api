<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Factory\Form\DataTransformer;

use App\Infrastructure\Factory\Form\DataTransformer\StationDetailTypeToStringTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Tests\Support\Builder\StationDetailTypeBuilder;

class StationDetailTypeToStringTransformerUnitTest extends TestCase
{
    /**
     * @var StationDetailTypeToStringTransformer
     */
    private $transformer;

    /**
     * @test
     */
    public function it_can_transform_a_bike_station_detail_type_to_string()
    {
        $this->assertEquals(
            'BIKE',
            $this->transformer->transform(StationDetailTypeBuilder::create()->withTypeBike()->build())
        );
    }

    /**
     * @test
     */
    public function it_can_transform_an_electric_bike_station_detail_type_to_string()
    {
        $this->assertEquals(
            'ELECTRIC_BIKE',
            $this->transformer->transform(StationDetailTypeBuilder::create()->withTypeElectricBike()->build())
        );
    }

    /**
     * @test
     */
    public function it_can_transform_a_non_station_detail_to_empty_string()
    {
        $this->assertEquals(
            '',
            $this->transformer->transform('not a StationDetailType instance.')
        );
    }

    /**
     * @test
     */
    public function it_can_reverse_transform_a_bike_type_string_to_a_station_detail_type()
    {
        $this->assertEquals(
            $this->transformer->reverseTransform('BIKE'),
            StationDetailTypeBuilder::create()->withTypeBike()->build()
        );
    }

    /**
     * @test
     */
    public function it_can_reverse_transform_an_electric_bike_type_string_to_a_station_detail_type()
    {
        $this->assertEquals(
            $this->transformer->reverseTransform('ELECTRIC_BIKE'),
            StationDetailTypeBuilder::create()->withTypeElectricBike()->build()
        );
    }

    /**
     * @test
     */
    public function it_can_not_reverse_transform_a_null_type()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('To reverse transform to a StationDetailType, "string" type is expected.');

        $this->transformer->reverseTransform(null);
    }

    /**
     * @test
     */
    public function it_can_not_reverse_transform_a_type_that_is_not_a_string()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('To reverse transform to a StationDetailType, "string" type is expected.');

        $this->transformer->reverseTransform(['invalid', 'input']);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->transformer = new StationDetailTypeToStringTransformer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->transformer = null;

        parent::tearDown();
    }
}
