<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

final class HttpQueryResponseIsNotValidException extends \Exception implements HttpQueryExceptionInterface
{
    public static function causedBy($reason): self
    {
        throw new self(sprintf('Http Query Response not valid caused by "%s".', $reason));
    }
}
