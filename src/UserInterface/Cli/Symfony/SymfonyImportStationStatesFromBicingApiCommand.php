<?php

declare(strict_types=1);

namespace App\UserInterface\Cli\Symfony;

use App\Application\Process\Manager\ImportStationStatesFromBicingApiManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SymfonyImportStationStatesFromBicingApiCommand extends Command
{
    /**
     * @var ImportStationStatesFromBicingApiManager
     */
    private $manager;

    /**
     * @param ImportStationStatesFromBicingApiManager $manager
     */
    public function __construct(ImportStationStatesFromBicingApiManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('bicing-api:import:stations-states')
            ->setDescription('Import Stations States from Bicing API data.')
            ->setHelp('This command will add stations states to existing stations.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->manager->__invoke();
    }
}
