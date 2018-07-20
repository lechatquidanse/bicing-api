<?php

declare(strict_types=1);

namespace tests\App\Application\Process\Manager;

use SimpleBus\Message\Bus\MessageBus;

class SpyCommandBus implements MessageBus
{
    /**
     * @var array
     */
    private $commands = [];

    /**
     * @var bool
     */
    private static $willThrowException = false;

    public function handle($message)
    {
        if (true === self::$willThrowException) {
            throw new \Exception('An exception has been thrown while handling the command.');
        }

        $this->commands[] = $message;
    }

    public static function willThrowAnException(): void
    {
        self::$willThrowException = true;
    }

    public function commands(): array
    {
        return $this->commands;
    }

    public static function reset()
    {
        self::$willThrowException = false;
    }
}
