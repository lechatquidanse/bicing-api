<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\StationState;
use App\Infrastructure\Request\Symfony\SymfonyStationParamConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use tests\Support\Builder\StationBuilder;

class SymfonyStationParamConverterUnitTest extends TestCase
{
    /** @var SymfonyStationParamConverter */
    private $converter;

    /** @var MockStationRepository */
    private $repository;

    /** @test */
    public function it_can_support_station_class_name(): void
    {
        $this->assertTrue($this->converter->supports(new ParamConverter([
            'class' => Station::class,
        ])));
    }

    /** @test */
    public function it_can_not_support_class_name_different_than_station(): void
    {
        $this->assertFalse($this->converter->supports(new ParamConverter([
            'class' => StationState::class,
        ])));
    }

    /** @test */
    public function it_can_apply(): void
    {
        $station = StationBuilder::create()->build();

        $this->repository->add($station);

        $request = new Request([], [], ['id' => $station->stationId()->toString()]);

        $this->assertTrue($this->converter->apply(
            $request,
            new ParamConverter(['class' => Station::class, 'name' => 'station'])
        ));
        $this->assertTrue($request->attributes->has('station'));
        $this->assertEquals($station, $request->attributes->get('station'));
    }

    /** @test */
    public function it_can_not_apply_if_station_id_is_not_in_attributes(): void
    {
        $this->expectException(MissingMandatoryParametersException::class);

        $station = StationBuilder::create()->build();

        $this->repository->add($station);

        $request = new Request([], [], ['invalid_key' => $station->stationId()->toString()]);

        $this->assertTrue($this->converter->apply(
            $request,
            new ParamConverter(['class' => Station::class, 'name' => 'station'])
        ));
        $this->assertTrue($request->attributes->has('station'));
        $this->assertEquals($station, $request->attributes->get('station'));
    }

    /** @test */
    public function it_can_not_apply_a_station_that_does_not_exist(): void
    {
        $this->expectException(StationDoesNotExist::class);
        $this->expectExceptionMessage(
            'A station does not exist with external station Id "50ca0f4c-a474-40e3-a1d0-8fd0901b46d3".'
        );

        $this->repository->add(StationBuilder::create()->build());

        $this->converter->apply(
            new Request([], [], ['id' => '50ca0f4c-a474-40e3-a1d0-8fd0901b46d3']),
            new ParamConverter(['class' => Station::class, 'name' => 'station'])
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new MockStationRepository();
        $this->converter = new SymfonyStationParamConverter($this->repository);
    }

    protected function tearDown()
    {
        $this->converter = null;
        $this->repository = null;

        parent::tearDown();
    }
}
