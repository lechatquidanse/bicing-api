<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationQueryInterface;
use App\Application\UseCase\Query\AvailabilitiesInTimeIntervalByStationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\Station\StationRepositoryInterface;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use Ramsey\Uuid\Uuid;

final class AvailabilitiesInTimeIntervalByStationDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface // phpcs:ignore
{
    /** @var StationRepositoryInterface */
    private $stationRepository;

    /** @var AvailabilitiesInTimeIntervalByStationQueryInterface */
    private $availabilitiesQuery;

    /**
     * @param StationRepositoryInterface                          $stationRepository
     * @param AvailabilitiesInTimeIntervalByStationQueryInterface $availabilitiesQuery
     */
    public function __construct(
        StationRepositoryInterface $stationRepository,
        AvailabilitiesInTimeIntervalByStationQueryInterface $availabilitiesQuery
    ) {
        $this->stationRepository = $stationRepository;
        $this->availabilitiesQuery = $availabilitiesQuery;
    }

    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): AvailabilitiesInTimeIntervalByStationView {
        if (null === ($station = $this->stationRepository->findByStationId($id))) {
            throw StationDoesNotExist::withExternalStationId((string) $id);
        }

        return new AvailabilitiesInTimeIntervalByStationView(
            $station->stationId(),
            $this->availabilitiesQuery->find(Uuid::fromString($id), new DateTimeImmutableStringable('last week'))
        );
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return AvailabilitiesInTimeIntervalByStationView::class === $resourceClass;
    }
}
