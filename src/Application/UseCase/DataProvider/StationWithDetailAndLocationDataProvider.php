<?php

declare(strict_types=1);

namespace App\Application\UseCase\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationQueryInterface;
use App\Application\UseCase\Query\StationWithDetailAndLocationView;
use App\Domain\Exception\Station\StationDoesNotExist;
use Assert\Assert;
use Ramsey\Uuid\UuidInterface;

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
     * @param string        $resourceClass
     * @param UuidInterface $id
     * @param string|null   $operationName
     * @param array         $context
     *
     * @return StationWithDetailAndLocationView
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): StationWithDetailAndLocationView {
        Assert::that($id)->isInstanceOf(UuidInterface::class);

        $station = $this->query->find($id);

        if (null === $station) {
            throw StationDoesNotExist::withExternalStationId($id->toString());
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
