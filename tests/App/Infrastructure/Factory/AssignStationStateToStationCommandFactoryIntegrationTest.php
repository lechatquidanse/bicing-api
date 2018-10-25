<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Factory;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Domain\Model\StationState\StationStateStatus;
use App\Infrastructure\Factory\AssignStationStateToStationCommandFactory;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use tests\App\Infrastructure\System\MockClock;
use tests\Support\Builder\AvailabilityStationBuilder;
use tests\Support\TestCase\IntegrationTestCase;

class AssignStationStateToStationCommandFactoryIntegrationTest extends IntegrationTestCase
{
    /**
     * @var AssignStationStateToStationCommandFactory
     */
    private $factory;

    /**
     * @var MockClock
     */
    private $clock;

    /**
     * @test
     */
    public function it_can_create_from_availability_station_with_valid_data(): void
    {
        $createdAt = new \DateTimeImmutable();
        $expected = new AssignStationStateToStationCommand();

        $expected->externalStationId = '12';
        $expected->status = StationStateStatus::fromString('OPN');
        $expected->availableBikeNumber = 2;
        $expected->availableSlotNumber = 18;
        $expected->createdAt = $createdAt;

        $this->clock::willReturnDateTimeImmutable($createdAt);

        $this->assertEquals($expected, $this->factory->fromAvailabilityStation(
            AvailabilityStationBuilder::create()
                ->withId('12')
                ->withStatus('OPN')
                ->withBikes(2)
                ->withSlots(18)
                ->build()
        ));

        $this->clock::reset();
    }

    /**
     * @test
     */
    public function it_can_not_create_from_availability_station_with_invalid_status(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form invalid when creating AssignStationStateToStationCommand.');

        $this->factory->fromAvailabilityStation(AvailabilityStationBuilder::create()
            ->withStatus('')
            ->build());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clock = $this->getContainer()->get('test.app.system.clock.mock');
        $this->factory = $this->getContainer()->get('test.app.factory.assign_station_state_to_station_command');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->clock = null;
        $this->factory = null;

        parent::tearDown();
    }
}
