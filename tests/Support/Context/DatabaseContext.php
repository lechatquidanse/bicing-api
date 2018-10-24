<?php

declare(strict_types=1);

namespace tests\Support\Context;

use Behat\Behat\Context\Context;
use tests\Support\Service\DoctrineDatabaseManager;

class DatabaseContext implements Context
{
    /** @var DoctrineDatabaseManager */
    private $databaseManager;

    /**
     * @param DoctrineDatabaseManager $databaseManager
     */
    public function __construct(DoctrineDatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /** @BeforeScenario @database*/
    public function setUp()
    {
        $this->databaseManager->setUp();
    }
}
