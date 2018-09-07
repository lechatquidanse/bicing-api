<?php

declare(strict_types=1);

namespace tests\Support\Service;

use Assert\Assertion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use tests\Support\Builder\BuilderInterface;

class DoctrineDatabaseManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DoctrineDatabaseSetup constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array ...$builders
     *
     * @return object|null
     */
    public function buildPersisted(...$builders)
    {
        Assertion::allIsInstanceOf($builders, BuilderInterface::class);

        $lastPersistedObject = null;

        foreach ($builders as $builder) {
            $this->save($lastPersistedObject = $builder->build());
        }

        return $lastPersistedObject;
    }

    public function setUp(): void
    {
        $this->truncateTables();
    }

    private function truncateTables(): void
    {
        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata $meta */
        foreach ($metaData as $meta) {
            $this->entityManager->getConnection()->executeQuery(sprintf('TRUNCATE "%s" CASCADE;', $meta->getTableName()));
        }
    }

    private function save($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();

        return $object;
    }
}
