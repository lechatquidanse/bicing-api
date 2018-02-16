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
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client    = static::createClient();
        $this->container = $this->client->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->client    = null;
        $this->container = null;

        parent::tearDown();
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }
}

