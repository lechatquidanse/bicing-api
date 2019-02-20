<?php

declare(strict_types=1);

namespace tests\Support\TestCase;

use Doctrine\Common\Persistence\ObjectManager;
use tests\Support\Service\DoctrineDatabaseManager;

abstract class DatabaseTestCase extends IntegrationTestCase
{
    /**
     * @param array ...$builders
     *
     * @return object|null
     */
    protected function buildPersisted(...$builders)
    {
        return $this->databaseSetup()->buildPersisted(...$builders);
    }

    /**
     * @param string $class
     * @param mixed  $id
     *
     * @return object|null
     */
    protected function find(string $class, $id)
    {
        return $this->managerForClass($class)->find($class, $id);
    }

    /**
     * @param string $class
     *
     * @return ObjectManager
     */
    private function managerForClass(string $class): ObjectManager
    {
        return $this->getContainer()->get('doctrine')->getManagerForClass($class);
    }

    /**
     * @return DoctrineDatabaseManager
     */
    private function databaseSetup(): DoctrineDatabaseManager
    {
        return $this->getContainer()->get('test.database_manager');
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->databaseSetup()->setUp();
    }
}
