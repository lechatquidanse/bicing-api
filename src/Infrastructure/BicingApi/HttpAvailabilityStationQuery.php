<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use App\Infrastructure\Http\HttpQueryClientInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;

final class HttpAvailabilityStationQuery implements AvailabilityStationQueryInterface
{
    /** @var string */
    private const DESERIALIZE_EXCEPTION_MESSAGE = 'An error occurred during AvailabilityStation query deserialization ';

    /**
     * @var string
     */
    const REQUEST_URI = '/get-stations';

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
     * @return array
     */
    private function deserialize(ResponseInterface $response): array
    {
        /** @var ApiResponse $apiResponse */
        $apiResponse = $this->serializer->deserialize(
            (string) $response->getBody(),
            ApiResponse::class,
            self::RESPONSE_FORMAT
        );

        if (false === $apiResponse->isValid()) {
            throw new \RuntimeException(self::DESERIALIZE_EXCEPTION_MESSAGE);
        }

        return $apiResponse->stations();
    }
}
