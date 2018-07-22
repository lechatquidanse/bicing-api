<?php

declare(strict_types=1);

namespace tests\Support\TestCase;

use Assert\Assertion;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
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
        $em = $this->entityManager();
//        $params = $em->getConnection()->getParams();
//
//        if (file_exists($params['path'])) {
//            unlink($params['path']);
//        }

        $schemaTool = new SchemaTool($em);
        $schemaTool->createSchema($em->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
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
