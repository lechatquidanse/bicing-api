<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class FakeHttpOkResponse extends AbstractFakeHttpResponse implements ResponseInterface
{
    public function getStatusCode()
    {
        return Response::HTTP_OK;
    }
}
