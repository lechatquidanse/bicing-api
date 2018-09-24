<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Application\UseCase\Query\LastStationStateByStationView;
use App\Domain\Exception\Station\StationDoesNotExist;

final class LastStationStateByStationDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface, RestrictedDataProviderInterface // phpcs:ignore
{
    /** @var LastStationStateByStationQueryInterface */
    private $query;

    /**
     * @param LastStationStateByStationQueryInterface $query
     */
    public function __construct(LastStationStateByStationQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * Retrieves an item.
     *
     * @param array|int|string $id
     *
     * @return object|null
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ) {
        if (null === ($stationSate = $this->query->find($id))) {
            throw StationDoesNotExist::withExternalStationId((string) $id);
        }

        return LastStationStateByStationView::fromArray($stationSate);
    }

    /**
     * Retrieves a collection.
     *
     * @return array|\Traversable
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $stationSates = $this->query->findAll();

        foreach ($stationSates as $stationSate) {
            yield LastStationStateByStationView::fromArray($stationSate);
        }
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     * @param array       $context
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return LastStationStateByStationView::class === $resourceClass;
    }
}
