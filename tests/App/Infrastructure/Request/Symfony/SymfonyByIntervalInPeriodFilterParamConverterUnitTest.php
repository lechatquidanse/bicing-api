<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use App\Domain\Model\Station\Station;
use App\Infrastructure\Request\Symfony\SymfonyByIntervalInPeriodFilterParamConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use tests\App\Infrastructure\Persistence\Doctrine\Type\SpyLogger;

class SymfonyByIntervalInPeriodFilterParamConverterUnitTest extends TestCase
{
    /** @var SymfonyByIntervalInPeriodFilterParamConverter */
    private $converter;

    /** @test */
    public function it_can_support_interval_in_period_filter_class_name(): void
    {
        $this->assertTrue($this->converter->supports(new ParamConverter([
            'class' => ByIntervalInPeriodFilter::class,
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
            new ParamConverter(['class' => ByIntervalInPeriodFilter::class, 'name' => 'filter'])
        ));
        $this->assertTrue($request->attributes->has('filter'));
        $this->assertEquals(
            ByIntervalInPeriodFilter::fromRawStringValues(
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
            'class' => ByIntervalInPeriodFilter::class,
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
            ByIntervalInPeriodFilter::fromRawStringValues($defaultPeriodStart, $defaultPeriodEnd, $defaultInterval),
            $request->attributes->get('filter')
        );
    }

    /** @test */
    public function it_can_log_error_from_bad_value_set_in_option(): void
    {
        $logger = new SpyLogger('test');
        $this->converter->setLogger($logger);

        $configuration = new ParamConverter([
            'class' => ByIntervalInPeriodFilter::class,
            'name' => 'filter',
            'options' => [
                'defaultPeriodStart' => 'bad_value_option',
                'defaultPeriodEnd' => 'bad_value_option End',
                'defaultInterval' => '10 minute',
            ],
        ]);

        try {
            $this->converter->apply(new Request(), $configuration);
        } catch (\Exception $e) {
            $this->assertEquals([
                'An error occurred during period creation from options values defaultPeriodStart',
                'An error occurred during period creation from options values defaultPeriodEnd',
            ], $logger->errors());
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->converter = new SymfonyByIntervalInPeriodFilterParamConverter();
    }

    protected function tearDown()
    {
        $this->converter = null;

        parent::tearDown();
    }
}
