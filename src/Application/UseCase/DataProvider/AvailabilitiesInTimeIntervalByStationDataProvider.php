<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationQueryInterface;
use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\Station\StationRepositoryInterface;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use Ramsey\Uuid\Uuid;

/**
 * @todo add tests
 * @todo add operation name for support
 */
final class AvailabilitiesInTimeIntervalByStationDataProvider implements ItemDataProviderInterface
{
    /** @var StationRepositoryInterface */
    private $stationRepository;

    /** @var AvailabilitiesInTimeIntervalByStationQueryInterface */
    private $availabilitiesQuery;

    /**
     * @param StationRepositoryInterface                          $stationRepository
     * @param AvailabilitiesInTimeIntervalByStationQueryInterface $availabilitiesQuery
     */
    public function __construct(StationRepositoryInterface $stationRepository, AvailabilitiesInTimeIntervalByStationQueryInterface $availabilitiesQuery)
    {
        $this->stationRepository = $stationRepository;
        $this->availabilitiesQuery = $availabilitiesQuery;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): AvailabilitiesInTimeIntervalByStationView
    {
        if (!$this->supports($resourceClass, $operationName)) {
            throw new ResourceClassNotSupportedException(sprintf(
                'Resource Class %s not supported by Availabilities In Time Interval By Station DataProvider',
                $resourceClass
            ));
        }

        if (null === ($station = $this->stationRepository->findByStationId($id))) {
            throw StationDoesNotExist::withExternalStationId((string) $id);
        }

        return new AvailabilitiesInTimeIntervalByStationView(
            $station->stationId(),
            $this->availabilitiesQuery->find(Uuid::fromString($id), new DateTimeImmutableStringable('now')));
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null): bool
    {
        return AvailabilitiesInTimeIntervalByStationView::class === $resourceClass;
    }
}
