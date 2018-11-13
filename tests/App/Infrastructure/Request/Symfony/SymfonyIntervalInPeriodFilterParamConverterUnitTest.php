<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\IntervalInPeriodFilter;
use App\Domain\Model\Station\Station;
use App\Infrastructure\Request\Symfony\SymfonyIntervalInPeriodFilterParamConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SymfonyIntervalInPeriodFilterParamConverterUnitTest extends TestCase
{
    /** @var SymfonyIntervalInPeriodFilterParamConverter */
    private $converter;

    /** @test */
    public function it_can_support_interval_in_period_filter_class_name(): void
    {
        $this->assertTrue($this->converter->supports(new ParamConverter([
            'class' => IntervalInPeriodFilter::class,
        ])));
    }

    /** @test */
    public function it_can_not_support_class_name_different_than_interval_in_period_filter(): void
    {
        $this->assertFalse($this->converter->supports(new ParamConverter([
            'class' => Station::class,
        ])));
    }

    /** @test */
    public function it_can_apply(): void
    {
        $request = new Request([
            'periodStart' => '2016-08-24 08:45:21',
            'periodEnd' => '2018-12-01 16:25:31',
            'interval' => '5 minute',
        ]);

        $this->assertTrue($this->converter->apply(
            $request,
            new ParamConverter(['class' => IntervalInPeriodFilter::class, 'name' => 'filter'])
        ));
        $this->assertTrue($request->attributes->has('filter'));
        $this->assertEquals(
            IntervalInPeriodFilter::fromRawStringValues(
                '2016-08-24 08:45:21',
                '2018-12-01 16:25:31',
                '5 minute'
            ),
            $request->attributes->get('filter')
        );
    }

    /** @test */
    public function it_can_apply_with_default_value_option_if_not_in_request(): void
    {
        $request = new Request();
        $defaultPeriodStart = (new \DateTime('last week -1 hour'))->format('Y-m-d H:i:s');
        $defaultPeriodEnd = (new \DateTime('last week'))->format('Y-m-d H:i:s');
        $defaultInterval = '10 minute';

        $configuration = new ParamConverter([
            'class' => IntervalInPeriodFilter::class,
            'name' => 'filter',
            'options' => [
                'defaultPeriodStart' => $defaultPeriodStart,
                'defaultPeriodEnd' => $defaultPeriodEnd,
                'defaultInterval' => $defaultInterval,
            ],
        ]);

        $this->assertTrue($this->converter->apply($request, $configuration));
        $this->assertTrue($request->attributes->has('filter'));
        $this->assertEquals(
            IntervalInPeriodFilter::fromRawStringValues($defaultPeriodStart, $defaultPeriodEnd, $defaultInterval),
            $request->attributes->get('filter')
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->converter = new SymfonyIntervalInPeriodFilterParamConverter();
    }

    protected function tearDown()
    {
        $this->converter = null;

        parent::tearDown();
    }
}
