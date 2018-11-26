<?php

declare(strict_types=1);

namespace tests\App\UserInterface\Cli\Symfony;

use App\UserInterface\Cli\Symfony\SymfonyUpdateStationsLocationGeometryCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use tests\Support\TestCase\IntegrationTestCase;

class SymfonyUpdateStationsLocationGeometryCommandIntegrationTest extends IntegrationTestCase
{
    /** @var SymfonyUpdateStationsLocationGeometryCommand */
    private $command;

    /** @test */
    public function it_can_be_configured_as_expected(): void
    {
        $this->assertEquals('Update all stations location geometry.', $this->command->getDescription());
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

        $this->command = (new Application(static::createKernel()))->find('bicing-api:update:stations-location-geometry');
    }

    protected function tearDown()
    {
        $this->command = null;

        parent::tearDown();
    }
}
