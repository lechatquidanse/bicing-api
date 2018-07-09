<?php

declare(strict_types=1);

namespace Tests\Support\TestCase;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Test Case description and utils for integration test.
 */
abstract class IntegrationTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ContainerInterface
     */
    private $containerTest;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->containerTest = $this->client->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->client = null;
        $this->containerTest = null;

        parent::tearDown();
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->containerTest;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }
}

