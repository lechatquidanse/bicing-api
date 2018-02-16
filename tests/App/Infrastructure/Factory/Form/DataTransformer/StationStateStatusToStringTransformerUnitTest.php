<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Factory\Form\DataTransformer;

use App\Infrastructure\Factory\Form\DataTransformer\StationStateStatusToStringTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Tests\Support\Builder\StationStateStatusBuilder;

class StationStateStatusToStringTransformerUnitTest extends TestCase
{
    /**
     * @var StationStateStatusToStringTransformer
     */
    private $transformer;

    /**
     * @test
     */
    public function it_can_transform_an_opened_station_state_status_to_string()
    {
        $this->assertEquals(
            'OPENED',
            $this->transformer->transform(StationStateStatusBuilder::create()->withStatusOpened()->build())
        );
    }

    /**
     * @test
     */
    public function it_can_transform_a_closed_station_state_status_to_string()
    {
        $this->assertEquals(
            'CLOSED',
            $this->transformer->transform(StationStateStatusBuilder::create()->withStatusClosed()->build())
        );
    }

    /**
     * @test
     */
    public function it_can_transform_a_non_station_state_status_to_empty_string()
    {
        $this->assertEquals(
            '',
            $this->transformer->transform('not a StationStateStatus instance.')
        );
    }

    /**
     * @test
     */
    public function it_can_reverse_transform_an_opened_status_string_to_a_station_state_status()
    {
        $this->assertEquals(
            $this->transformer->reverseTransform('OPENED'),
            StationStateStatusBuilder::create()->withStatusOpened()->build()
        );
    }

    /**
     * @test
     */
    public function it_can_reverse_transform_a_closed_status_string_to_a_station_state_status()
    {
        $this->assertEquals(
            $this->transformer->reverseTransform('CLOSED'),
            StationStateStatusBuilder::create()->withStatusClosed()->build()
        );
    }

    /**
     * @test
     */
    public function it_can_not_reverse_transform_a_null_status()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('To reverse transform to a StationStateStatus, "string" type is expected.');

        $this->transformer->reverseTransform(null);
    }

    /**
     * @test
     */
    public function it_can_not_reverse_transform_a_status_that_is_not_a_string()
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('To reverse transform to a StationStateStatus, "string" type is expected.');

        $this->transformer->reverseTransform(['invalid', 'input']);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->transformer = new StationStateStatusToStringTransformer();
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
