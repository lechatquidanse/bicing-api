<?php

declare(strict_types=1);

namespace App\UserInterface\Cli\Symfony;

use App\Application\Process\Manager\ImportStationsFromBicingApiManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyImportStationsFromBicingApiCommand extends Command
{
    /**
     * @var ImportStationsFromBicingApiManager
     */
    private $manager;

    /**
     * @param ImportStationsFromBicingApiManager $manager
     */
    public function __construct(ImportStationsFromBicingApiManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('bicing-api:import:stations')
            ->setDescription('Import Stations from Bicing API data.')
            ->setHelp('This command will create new stations.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->manager->__invoke();
    }
}
