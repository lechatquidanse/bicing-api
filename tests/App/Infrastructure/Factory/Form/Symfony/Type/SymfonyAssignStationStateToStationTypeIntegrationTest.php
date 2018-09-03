<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Factory\Form\Symfony\Type;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Domain\Model\StationState\StationStateStatus;
use App\Infrastructure\Factory\Form\Symfony\Type\SymfonyAssignStationStateToStationType;
use Symfony\Component\Form\FormInterface;
use tests\Support\TestCase\IntegrationTestCase;

class SymfonyAssignStationStateToStationTypeIntegrationTest extends IntegrationTestCase
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @test
     */
    public function it_can_be_valid_with_valid_data_submitted()
    {
        $this->form->submit([
            'status' => 'OPENED',
            'externalStationId' => '6544',
            'availableBikeNumber' => 12,
            'availableSlotNumber' => 19,
        ]);

        $this->assertTrue($this->form->isValid());
    }

    /**
     * @test
     */
    public function it_can_get_data_once_valid_data_have_been_submitted()
    {
        $this->form->submit([
            'status' => 'OPENED',
            'externalStationId' => '6544',
            'availableBikeNumber' => 12,
            'availableSlotNumber' => 19,
        ]);

        $command = new AssignStationStateToStationCommand();

        $command->status = StationStateStatus::fromString('OPENED');
        $command->externalStationId = '6544';
        $command->availableBikeNumber = 12;
        $command->availableSlotNumber = 19;

        $this->assertEquals($command, $this->form->getData());
    }

    /**
     * @test
     */
    public function it_can_not_be_valid_if_submitted_data_are_missing()
    {
        $this->form->submit([]);

        $this->assertFalse($this->form->isValid());
    }

    /**
     * @test
     */
    public function it_can_not_be_valid_if_submitted_data_are_not_typed_as_expected()
    {
        $this->form->submit([
            'statedAt' => 0,
            'status' => 0,
            'externalStationId' => 0,
            'availableBikeNumber' => 'not_valid',
            'availableSlotNumber' => 'not_valid',
        ]);

        $this->assertFalse($this->form->isValid());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->form = $this->getContainer()->get('form.factory')->create(SymfonyAssignStationStateToStationType::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->form = null;

        parent::tearDown();
    }
}
