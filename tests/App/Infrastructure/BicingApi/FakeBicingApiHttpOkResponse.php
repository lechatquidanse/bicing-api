<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\BicingApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class FakeBicingApiHttpOkResponse implements ResponseInterface
{
    public function getBody()
    {
        return <<<'json'
[
    {
        "id": "1",
        "district": "2",
        "lon": "2.180042",
        "lat": "41.397952",
        "bikes": "7",
        "slots": "20",
        "zip": "08013",
        "address": "Gran Via Corts Catalanes",
        "addressNumber": "760",
        "nearbyStations": "24,369,387,426",
        "status": "OPN",
        "name": "01 - C/ GRAN VIA CORTS CATALANES 760",
        "stationType": "BIKE"
    },
    {
        "id": "2",
        "district": "2",
        "lon": "2.17706",
        "lat": "41.39553",
        "bikes": "16",
        "slots": "11",
        "zip": "08010",
        "address": "Roger de Flor/ Gran Vía",
        "addressNumber": "126",
        "nearbyStations": "360,368,387,414",
        "status": "OPN",
        "name": "02 - C/ ROGER DE FLOR, 126",
        "stationType": "BIKE"
    }
]
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
