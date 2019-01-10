<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Factory\Form\Symfony\Type;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Infrastructure\Factory\Form\Symfony\Type\SymfonyCreateStationType;
use Symfony\Component\Form\FormInterface;
use tests\Support\Builder\StationDetailTypeBuilder;
use tests\Support\TestCase\IntegrationTestCase;

class SymfonyCreateStationTypeIntegrationTest extends IntegrationTestCase
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @test
     */
    public function it_can_be_valid_with_valid_data_submitted(): void
    {
        $this->form->submit([
            'name' => '01 - C/ GRAN VIA CORTS CATALANES 760',
            'type' => 'BIKE',
            'externalStationId' => '1',
            'nearByExternalStationIds' => ['24', '369', '387', '426'],
            'address' => 'Gran Via Corts Catalanes',
            'addressNumber' => '760',
            'districtCode' => 2,
            'zipCode' => '08013',
            'latitude' => 41.397952,
            'longitude' => 2.180042,
        ]);

        $this->assertTrue($this->form->isValid());
    }

    /**
     * @test
     */
    public function it_can_be_valid_with_only_mandatory_valid_data_submitted(): void
    {
        $this->form->submit([
            'name' => '01 - C/ GRAN VIA CORTS CATALANES 760',
            'type' => 'BIKE',
            'externalStationId' => '1',
            'address' => 'Gran Via Corts Catalanes',
            'latitude' => 41.397952,
            'longitude' => 2.180042,
        ]);

        $this->assertTrue($this->form->isValid());
    }

    /**
     * @test
     */
    public function it_can_get_data_once_valid_data_have_been_submitted(): void
    {
        $this->form->submit([
            'name' => '02 - C/ ROGER DE FLOR, 126',
            'type' => 'BIKE',
            'externalStationId' => '2',
            'nearByExternalStationIds' => ['360', '368', '387', '414'],
            'address' => 'Roger de Flor/ Gran Vía',
            'addressNumber' => '126',
            'districtCode' => 2,
            'zipCode' => '08010',
            'latitude' => 41.39553,
            'longitude' => 2.17706,
        ]);

        $command = new CreateStationCommand();

        $command->name = '02 - C/ ROGER DE FLOR, 126';
        $command->type = StationDetailTypeBuilder::create()->withTypeBike()->build();
        $command->externalStationId = '2';
        $command->nearByExternalStationIds = ['360', '368', '387', '414'];
        $command->address = 'Roger de Flor/ Gran Vía';
        $command->addressNumber = '126';
        $command->districtCode = 2;
        $command->zipCode = '08010';
        $command->latitude = 41.39553;
        $command->longitude = 2.17706;

        $this->assertEquals($command, $this->form->getData());
    }

    /**
     * @test
     */
    public function it_can_not_be_valid_if_submitted_data_are_missing(): void
    {
        $this->form->submit([]);

        $this->assertFalse($this->form->isValid());
    }

    /**
     * @test
     */
    public function it_can_not_be_valid_if_submitted_data_are_not_typed_as_expected(): void
    {
        $this->form->submit([
            'name' => 0,
            'type' => 0,
            'externalStationId' => 0,
            'nearByExternalStationIds' => 0,
            'address' => 0,
            'addressNumber' => 0,
            'districtCode' => 'invalid',
            'latitude' => 'invalid',
            'longitude' => 'invalid',
        ]);

        $this->assertFalse($this->form->isValid());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->form = $this->getContainer()->get('form.factory')->create(SymfonyCreateStationType::class);
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
