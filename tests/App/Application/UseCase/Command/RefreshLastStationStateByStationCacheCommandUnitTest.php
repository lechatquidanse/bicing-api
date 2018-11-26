<?php

declare(strict_types=1);

namespace tests\App\Application\UseCase\Command;

use App\Application\UseCase\Command\RefreshLastStationStateByStationCacheCommand;
use PHPUnit\Framework\TestCase;

final class RefreshLastStationStateByStationCacheCommandUnitTest extends TestCase
{
    /** @test */
    public function it_can_get_ttl(): void
    {
        $command = RefreshLastStationStateByStationCacheCommand::create(3600);

        $this->assertEquals(3600, $command->ttl());
    }
}
