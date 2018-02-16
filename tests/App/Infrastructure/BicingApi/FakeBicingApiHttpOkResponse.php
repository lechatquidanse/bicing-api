<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\BicingApi;

use Psr\Http\Message\ResponseInterface;
use Tests\App\Infrastructure\Http\AbstractFakeHttpResponse;

class FakeBicingApiHttpOkResponse extends AbstractFakeHttpResponse implements ResponseInterface
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
}
