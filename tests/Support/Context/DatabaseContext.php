<?php

declare(strict_types=1);

namespace tests\Support\Context;

class DatabaseContext extends DefaultContext
{
    /** @BeforeScenario */
    public function setUp()
    {
        $this->getContainer()->get('test.database_setup')->setUp();
    }
}
