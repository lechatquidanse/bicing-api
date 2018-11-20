<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Subscriber;

use App\Infrastructure\Persistence\Doctrine\Subscriber\DoctrineMigrationSubscriber;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use tests\Support\TestCase\IntegrationTestCase;

final class DoctrineMigrationSubscriberIntegrationTest extends IntegrationTestCase
{
    /** @var DoctrineMigrationSubscriber */
    private $subscriber;

    /** @test */
    public function it_can_add_namespaces_that_does_not_already_exist_to_schema(): void
    {
        $schema = new Schema();
        $event = new GenerateSchemaEventArgs($this->getContainer()->get('doctrine.orm.entity_manager'), $schema);

        $this->subscriber->postGenerateSchema($event);

        $this->assertEquals([
            '_timescaledb_cache' => '_timescaledb_cache',
            '_timescaledb_catalog' => '_timescaledb_catalog',
            '_timescaledb_internal' => '_timescaledb_internal',
            'public' => 'public',
        ], $schema->getNamespaces());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->subscriber = new DoctrineMigrationSubscriber();
    }

    protected function tearDown()
    {
        $this->subscriber = null;

        parent::tearDown();
    }
}
