<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Type;

use Monolog\Logger;

final class SpyLogger extends Logger
{
    private $errors = [];

    /**
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function error($message, array $context = []): bool
    {
        $this->errors[] = $message;

        return true;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
