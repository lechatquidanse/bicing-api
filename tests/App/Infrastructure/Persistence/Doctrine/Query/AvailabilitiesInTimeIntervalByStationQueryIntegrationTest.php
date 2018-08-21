<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Query;

use App\Infrastructure\Persistence\Doctrine\Query\DoctrineStationStateAvailabilitiesInIntervalByStationQuery;
use tests\Support\TestCase\DatabaseTestCase;

class AvailabilitiesInTimeIntervalByStationQueryIntegrationTest extends DatabaseTestCase
{
    /** @var DoctrineStationStateAvailabilitiesInIntervalByStationQuery */
    private $query;

    /** @todo use a database (real or in-memory) with pdo_pgsql installed so we can run some specific function not know by sqlite*/
//    public function it_can_find_availabilities_with_opened_station_state_status_assigned_to_a_station(): void
//    {
//        $result = $this->query->find(Uuid::uuid4());
//
//        var_dump($result);
//    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();

        $this->query = $this->getContainer()->get('test.app.query.availabilites_in_time_interval_by_station_query');
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->query = null;

        parent::tearDown();
    }
}
