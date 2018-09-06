<?php

declare(strict_types=1);

namespace tests\Support\Context;

use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

class DefaultContext implements KernelAwareContext
{
    use KernelDictionary;

    protected function buildPersisted(...$builders)
    {
        return $this->getContainer()->get('test.database_setup')->buildPersisted($builders);
    }
}
