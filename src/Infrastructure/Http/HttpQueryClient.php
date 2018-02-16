<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Http\Exception\HttpQueryRequestIsNotValidException;
use App\Infrastructure\Http\Exception\HttpQueryResponseIsNotValidException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Http Client to query data from an external api threw GET method.
 */
class HttpQueryClient extends Client implements HttpQueryClientInterface
{
    use LoggerAwareTrait;

    /**
     * @param string $uri
     *
     * @return ResponseInterface
     * @throws HttpQueryResponseIsNotValidException if response is not valid.
     * @throws HttpQueryRequestIsNotValidException if request has encountered some issue.
     */
    public function query(string $uri): ResponseInterface
    {
        try {
            $response = $this->request(Request::METHOD_GET, $uri);

            if (false === $this->isValidResponse($response)) {
                throw HttpQueryResponseIsNotValidException::causedBy(
                    sprintf('Status code %d invalid.', $response->getStatusCode())
                );
            }

            return $response;
        } catch (RequestException $exception) {
            $this->error($exception);

            throw HttpQueryRequestIsNotValidException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    private function isValidResponse(ResponseInterface $response): bool
    {
        return Response::HTTP_OK === $response->getStatusCode();
    }

    /**
     * @param RequestException $exception
     */
    private function error(RequestException $exception)
    {
        if (null !== $this->logger) {
            $this->logger->error(
                'External API call fail',
                [
                    'request'  => $exception->getRequest(),
                    'response' => $exception->getResponse(),
                ]
            );
        }
    }
}
