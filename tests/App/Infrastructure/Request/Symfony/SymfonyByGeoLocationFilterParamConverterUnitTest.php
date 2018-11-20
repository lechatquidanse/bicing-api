<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
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
        $request = new Request(['geo_location_filter' => '41.373,2.17031,450.35']);

        $this->assertTrue($this->converter->apply(
            $request,
            new ParamConverter(['class' => ByGeoLocationFilter::class, 'name' => 'filter'])
        ));
        $this->assertTrue($request->attributes->has('filter'));
        $this->assertEquals(
            ByGeoLocationFilter::fromRawValues(41.373, 2.17031, 450.35),
            $request->attributes->get('filter')
        );
    }

    /** @test */
    public function it_can_not_apply_if_query_in_request_is_not_float(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Value "bad_query_pattern" does not match expected expression (for example: \'?geo_location_filter=41.373,2.17031,450.35\').'
        );

        $request = new Request(['geo_location_filter' => 'bad_query_pattern']);

        $this->converter->apply(
            $request,
            new ParamConverter(['class' => ByGeoLocationFilter::class, 'name' => 'filter'])
        );
    }

    /** @test */
    public function it_can_not_apply_if_no_query_in_request(): void
    {
        $request = new Request();
        $this->assertFalse($this->converter->apply(
            $request,
            new ParamConverter(['class' => ByGeoLocationFilter::class, 'name' => 'filter'])
        ));
        $this->assertNull($request->attributes->get('filter'));
    }

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
