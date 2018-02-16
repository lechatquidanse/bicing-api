<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class FakeHttpInvalidResponse extends AbstractFakeHttpResponse implements ResponseInterface
{
    public function getStatusCode()
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
