<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class FakeBicingApiHttpOkResponse implements ResponseInterface
{
    public function getBody()
    {
        return <<<'json'
{
    "url_icon": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio.png",
    "url_icon2": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio2.png",
    "url_icon3": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio3.png",
    "url_icon4": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio4.png",
    "url_icon5": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio5.png",
    "estacions_icon": "/modules/custom/mapa_disponibilitat/assets/icons/estacions.png",
    "parametros_filtro": [ ],
    "stations":[
        {
            "id": "406",
            "type": "BIKE-ELECTRIC",
            "latitude": "41.386512",
            "longitude": "2.164597",
            "streetName": "Gran Via de Les Corts Catalanes",
            "streetNumber": "592",
            "slots": "1",
            "bikes": "30",
            "type_bicing": 2,
            "electrical_bikes": 0,
            "mechanical_bikes": "30",
            "status": 1,
            "disponibilidad": 75,
            "icon": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio-75.png",
            "transition_start": "",
            "transition_end": ""
        },
        {
            "id": "405",
            "type": "BIKE",
            "latitude": "41.38551",
            "longitude": "2.152",
            "streetName": "Comte Borrell",
            "streetNumber": "198",
            "slots": "24",
            "bikes": "1",
            "type_bicing": 1,
            "electrical_bikes": 0,
            "mechanical_bikes": "0",
            "status": 0,
            "disponibilidad": 0,
            "icon": "/modules/custom/mapa_disponibilitat/assets/icons/ubicacio-0.png",
            "transition_start": "",
            "transition_end": ""
        }
    ]
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
