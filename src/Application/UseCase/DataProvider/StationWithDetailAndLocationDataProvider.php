<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
use App\Domain\Exception\Station\StationDoesNotExist;

/**
 * @todo add operation name for support
 */
class StationWithDetailAndLocationDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface
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
     *
     * @throws ResourceClassNotSupportedException
     */
    public function getItem(
        string $resourceClass,
        $id,
        string
        $operationName = null,
        array $context = []
    ): StationWithDetailAndLocationView {
        $this->allows($resourceClass, $operationName);

        if (null === ($station = $this->query->find($id))) {
            throw StationDoesNotExist::withExternalStationId((string) $id);
        }

        return StationWithDetailAndLocationView::fromArray($station);
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @return \Generator
     *
     * @throws ResourceClassNotSupportedException
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $this->allows($resourceClass, $operationName);

        $stations = $this->query->findAll();

        foreach ($stations as $station) {
            yield StationWithDetailAndLocationView::fromArray($station);
        }
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @throws ResourceClassNotSupportedException
     */
    private function allows(string $resourceClass, string $operationName = null): void
    {
        if (!$this->supports($resourceClass, $operationName)) {
            throw new ResourceClassNotSupportedException(sprintf(
                'Resource Class %s not supported by Station List DataProvider',
                $resourceClass
            ));
        }
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null): bool
    {
        return StationWithDetailAndLocationView::class === $resourceClass;
    }
}
