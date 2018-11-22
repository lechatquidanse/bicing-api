<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCase\Query\LastStationStateByStationQueryInterface;
use App\Application\UseCase\Query\LastStationStateByStationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use Assert\Assert;
use Ramsey\Uuid\UuidInterface;

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
     * @param string $resourceClass
     * @param UuidInterface $id
     * @param string|null $operationName
     * @param array $context
     *
     * @return LastStationStateByStationView|null|object
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    )
    {
        Assert::that($id)->isInstanceOf(UuidInterface::class);

        $stationSate = $this->query->find($id);

        if (null === $stationSate) {
            throw StationDoesNotExist::withExternalStationId($id->toString());
        }

        return LastStationStateByStationView::fromArray($stationSate);
    }

    /**
     * Retrieves a collection.
     *
     * @return \Generator
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $stationSates = $this->query->findAll();

        foreach ($stationSates as $stationSate) {
            yield LastStationStateByStationView::fromArray($stationSate);
        }
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return LastStationStateByStationView::class === $resourceClass;
    }
}
