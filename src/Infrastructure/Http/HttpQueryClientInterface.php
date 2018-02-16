<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Exception\InfrastructureException;
use Psr\Http\Message\ResponseInterface;

interface HttpQueryClientInterface extends InfrastructureException
{
    public function query(string $uri): ResponseInterface;
}
