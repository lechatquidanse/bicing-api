<?php

declare(strict_types=1);

namespace Tests\App\Infrastructure\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class MockHttpClient implements ClientInterface
{
    /**
     * @var bool
     */
    private static $willRespondNotOkStatusResponse = false;

    /**
     * @var bool
     */
    private static $willRaisedRequestException = false;

    public static function willRespondNotOkStatusResponse()
    {
        self::$willRespondNotOkStatusResponse = true;
    }

    public static function willRaisedRequestException()
    {
        self::$willRaisedRequestException = true;
    }

    public static function reset()
    {
        self::$willRespondNotOkStatusResponse = false;
        self::$willRaisedRequestException     = false;
    }

    public function request($method, $uri, array $options = [])
    {
        if (true === self::$willRespondNotOkStatusResponse) {
            return new FakeHttpInvalidResponse();
        } else if(true === self::$willRaisedRequestException) {
            throw new RequestException(
                'Mock Request Exception Error',
                new Request('GET', '/mock_request')
            );
        }

        return new FakeHttpOkResponse();
    }


    public function send(RequestInterface $request, array $options = [])
    {
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
    }
    public function requestAsync($method, $uri, array $options = [])
    {
    }

    public function getConfig($option = null)
    {
    }
}
