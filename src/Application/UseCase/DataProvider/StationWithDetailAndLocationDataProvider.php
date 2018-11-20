<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
use App\Domain\Exception\Station\StationDoesNotExist;

class StationWithDetailAndLocationDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var StationWithDetailAndLocationQueryInterface */
    private $query;

    /**
     * @param StationWithDetailAndLocationQueryInterface $query
     */
    public function __construct(StationWithDetailAndLocationQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @param string           $resourceClass
     * @param array|int|string $id
     * @param string|null      $operationName
     * @param array            $context
     *
     * @return StationWithDetailAndLocationView
     */
    public function getItem(
        string $resourceClass,
        $id,
        string
        $operationName = null,
        array $context = []
    ): StationWithDetailAndLocationView {
        if (null === ($station = $this->query->find($id))) {
            throw StationDoesNotExist::withExternalStationId((string) $id);
        }

        return StationWithDetailAndLocationView::fromArray($station);
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
        return StationWithDetailAndLocationView::class === $resourceClass;
    }
}
