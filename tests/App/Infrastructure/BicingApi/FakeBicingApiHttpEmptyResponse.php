<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class FakeBicingApiHttpEmptyResponse implements ResponseInterface
{
    public function getBody()
    {
        return <<<'json'
{
    "fake": "bad_value"
}
json;
    }

    public function getStatusCode()
    {
    }

    public function withStatus($code, $reasonPhrase = '')
    {
    }

    public function getReasonPhrase()
    {
    }

    public function getProtocolVersion()
    {
    }

    public function withProtocolVersion($version)
    {
    }

    public function getHeaders()
    {
    }

    public function hasHeader($name)
    {
    }

    public function getHeader($name)
    {
    }

    public function getHeaderLine($name)
    {
    }

    public function withHeader($name, $value)
    {
    }

    public function withAddedHeader($name, $value)
    {
    }

    public function withoutHeader($name)
    {
    }

    public function withBody(StreamInterface $body)
    {
    }
}
