<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Exception\InfrastructureExceptionInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpQueryClientInterface extends InfrastructureExceptionInterface
{
    public function query(string $uri): ResponseInterface;
}
