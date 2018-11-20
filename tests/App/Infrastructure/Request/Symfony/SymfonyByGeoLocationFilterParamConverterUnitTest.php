<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use App\Application\UseCase\Filter\IntervalInPeriodFilter;
use App\Domain\Model\Station\Station;
use App\Infrastructure\Request\Symfony\SymfonyByGeoLocationFilterParamConverter;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SymfonyByGeoLocationFilterParamConverterUnitTest extends TestCase
{
    /** @var SymfonyByGeoLocationFilterParamConverter */
    private $converter;

    /** @test */
    public function it_can_support_by_geo_location_filter_class_name(): void
    {
        $this->assertTrue($this->converter->supports(new ParamConverter([
            'class' => ByGeoLocationFilter::class,
        ])));
    }

    /** @test */
    public function it_can_not_support_class_name_different_than_by_geo_location_filter(): void
    {
        $this->assertFalse($this->converter->supports(new ParamConverter([
            'class' => Station::class,
        ])));
    }

    /** @test */
    public function it_can_apply(): void
    {
        $request = new Request([
            'latitude' => 41.390205,
            'longitude' => 2.154007,
            'limit' => 450.35,
        ]);

        $this->assertTrue($this->converter->apply(
            $request,
            new ParamConverter(['class' => ByGeoLocationFilter::class, 'name' => 'filter'])
        ));
        $this->assertTrue($request->attributes->has('filter'));
        $this->assertEquals(
            ByGeoLocationFilter::fromRawValues(41.390205, 2.154007, 450.35),
            $request->attributes->get('filter')
        );
    }

//    /** @test */
//    public function it_can_not_apply_if_no_queries(): void
//    {
//        $request = new Request();
//
//        $configuration = new ParamConverter([
//            'class' => IntervalInPeriodFilter::class,
//            'name' => 'filter',
//            'options' => [
//                'defaultLatitude' => 31.390205,
//                'defaultLongitude' => 2.954007,
//                'defaultLimit' => 50.00,
//            ],
//        ]);
//
//        $this->assertTrue($this->converter->apply($request, $configuration));
//        $this->assertTrue($request->attributes->has('filter'));
//        $this->assertEquals(
//            ByGeoLocationFilter::fromRawValues(31.390205, 2.954007, 50),
//            $request->attributes->get('filter')
//        );
//    }

    /** @test */
    public function it_can_not_apply_if_query_in_request_is_not_float(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('An error occurred during geo location creation from queries values');

        $request = new Request([
            'latitude' => 41.390205,
            'longitude' => 2.154007,
            'limit' => 'not_a_float',
        ]);

        $this->converter->apply(
            $request,
            new ParamConverter(['class' => ByGeoLocationFilter::class, 'name' => 'filter'])
        );
    }

//
//    /** @test */
//    public function it_can_not_apply_if_query_in_options_is_not_float(): void
//    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('An error occurred during geo location creation from queries values');
//
//        $request = new Request();
//        $configuration = new ParamConverter([
//            'class' => IntervalInPeriodFilter::class,
//            'name' => 'filter',
//            'options' => [
//                'defaultLatitude' => 'not_a_float',
//                'defaultLongitude' => 2.954007,
//                'defaultLimit' => 50,
//            ],
//        ]);
//
//        $this->converter->apply($request, $configuration);
//    }

    protected function setUp()
    {
        parent::setUp();

        $this->converter = new SymfonyByGeoLocationFilterParamConverter();
    }

    protected function tearDown()
    {
        $this->converter = null;

        parent::tearDown();
    }
}
