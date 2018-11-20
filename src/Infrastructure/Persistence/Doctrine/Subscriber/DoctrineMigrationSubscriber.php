<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

final class DoctrineMigrationSubscriber implements EventSubscriber
{
    /** @var array */
    private const USELESS_NAMESPACE_FOR_DOWN_MIGRATION = [
        '_timescaledb_cache',
        '_timescaledb_catalog',
        '_timescaledb_internal',
        'public',
    ];

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return ['postGenerateSchema'];
    }

    /**
     * @param GenerateSchemaEventArgs $args
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $useless = self::USELESS_NAMESPACE_FOR_DOWN_MIGRATION;

        array_walk($useless, [$this, 'createIfNotExistsNamespace'], $args->getSchema());
    }

    /**
     * @param string $namespaceName
     * @param int    $count
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    private function createIfNotExistsNamespace(string $namespaceName, int $count, Schema $schema): void
    {
        if (false === $schema->hasNamespace($namespaceName)) {
            $schema->createNamespace($namespaceName);
        }
    }
}
