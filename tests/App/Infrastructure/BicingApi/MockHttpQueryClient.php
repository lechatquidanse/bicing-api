<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\Http\HttpQueryClientInterface;
use Psr\Http\Message\ResponseInterface;

class MockHttpQueryClient implements HttpQueryClientInterface
{
    public function query(string $uri): ResponseInterface
    {
        return new FakeBicingApiHttpOkResponse();
    }
}
