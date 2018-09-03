<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

final class HttpQueryRequestIsNotValidException extends \Exception implements HttpQueryExceptionInterface
{
    public static function causedBy($issue): self
    {
        throw new self(sprintf('Http Query Request not valid caused by "%s".', $issue));
    }
}
