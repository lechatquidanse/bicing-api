<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\BicingApi;

use App\Infrastructure\Http\HttpQueryClientInterface;
use Psr\Http\Message\ResponseInterface;

class MockHttpQueryClient implements HttpQueryClientInterface
{
    /** @var bool */
    private static $willReturnEmptyResponse = false;

    /**
     * @param string $uri
     *
     * @return ResponseInterface
     */
    public function query(string $uri): ResponseInterface
    {
        if (true === self::$willReturnEmptyResponse) {
            return new FakeBicingApiHttpEmptyResponse();
        }

        return new FakeBicingApiHttpOkResponse();
    }

    public static function willReturnEmptyResponse(): void
    {
        self::$willReturnEmptyResponse = true;
    }

    public static function reset(): void
    {
        self::$willReturnEmptyResponse = false;
    }
}
