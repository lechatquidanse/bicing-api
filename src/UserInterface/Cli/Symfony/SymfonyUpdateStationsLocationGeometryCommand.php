<?php

declare(strict_types=1);

namespace App\UserInterface\Cli\Symfony;

use App\Application\Process\Manager\UpdateStationsLocationGeometryManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SymfonyUpdateStationsLocationGeometryCommand extends Command
{
    /** @var UpdateStationsLocationGeometryManager */
    private $manager;

    /**
     * @param UpdateStationsLocationGeometryManager $manager
     */
    public function __construct(UpdateStationsLocationGeometryManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('bicing-api:update:stations-location-geometry')
            ->setDescription('Update all stations location geometry.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->manager->__invoke();
    }
}
