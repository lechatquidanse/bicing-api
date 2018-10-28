<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use App\Infrastructure\Http\HttpQueryClientInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;

final class HttpAvailabilityStationQuery implements AvailabilityStationQueryInterface
{
    /**
     * @var string
     */
    const REQUEST_URI = '/availability_map/getJsonObject';

    /**
     * @var string
     */
    const RESPONSE_FORMAT = 'json';

    /**
     * @var HttpQueryClientInterface
     */
    private $client;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param HttpQueryClientInterface $client
     * @param SerializerInterface      $serializer
     */
    public function __construct(HttpQueryClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->deserialize($this->client->query(self::REQUEST_URI));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return AvailabilityStation[]
     */
    private function deserialize(ResponseInterface $response): array
    {
        return $this->serializer->deserialize(
            (string) $response->getBody(),
            'array<App\Infrastructure\BicingApi\AvailabilityStation>',
            self::RESPONSE_FORMAT
        );
    }
}
