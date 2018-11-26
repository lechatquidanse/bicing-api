<?php

declare(strict_types=1);

namespace tests\App\UserInterface\Cli\Symfony;

use App\UserInterface\Cli\Symfony\SymfonyImportStationStatesFromBicingApiCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use tests\Support\TestCase\IntegrationTestCase;

class SymfonyImportStationStatesFromBicingApiCommandIntegrationTest extends IntegrationTestCase
{
    /** @var SymfonyImportStationStatesFromBicingApiCommand */
    private $command;

    /** @test */
    public function it_can_be_configured_as_expected(): void
    {
        $this->assertEquals('Import Stations States from Bicing API data.', $this->command->getDescription());
        $this->assertEquals('This command will add stations states to existing stations.', $this->command->getHelp());
    }

    /** @test */
    public function it_can_execute_command(): void
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertEmpty($commandTester->getDisplay());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->command = (new Application(static::createKernel()))->find('bicing-api:import:stations-states');
    }

    protected function tearDown()
    {
        $this->command = null;

        parent::tearDown();
    }
}
