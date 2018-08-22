<?php

declare(strict_types=1);

namespace tests\Support\TestCase;

use Assert\Assertion;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use tests\Support\Builder\BuilderInterface;

abstract class DatabaseTestCase extends IntegrationTestCase
{
    /**
     * @param array ...$builders
     *
     * @return object|null
     */
    protected function buildPersisted(...$builders)
    {
        Assertion::allIsInstanceOf($builders, BuilderInterface::class);

        $lastPersistedObject = null;

        foreach ($builders as $builder) {
            $this->save($lastPersistedObject = $builder->build());
        }

        return $lastPersistedObject;
    }

    protected function setupDatabase()
    {
        $this->truncateTables();
    }

    private function truncateTables()
    {
        $em = $this->entityManager();

        $metaData = $em->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata $meta */
        foreach ($metaData as $meta) {
            $em->getConnection()->executeQuery(sprintf('TRUNCATE "%s" CASCADE;', $meta->getTableName()));
        }
    }

    protected function save($object)
    {
        $this->entityManager()->persist($object);
        $this->entityManager()->flush();

        return $object;
    }

    /**
     * @param string $class
     * @param mixed  $id
     *
     * @return null|object
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
     * @return EntityManager
     */
    private function entityManager(): EntityManager
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->setupDatabase();
    }
}
