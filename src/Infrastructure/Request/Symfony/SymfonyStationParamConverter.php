<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Symfony;

use App\Domain\Exception\Station\StationDoesNotExist;
use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

final class SymfonyStationParamConverter implements ParamConverterInterface
{
    /** @var string */
    private const STATION_ID_ROUTE_PARAMETER = 'id';

    /** @var StationRepositoryInterface */
    private $repository;

    /**
     * @param StationRepositoryInterface $repository
     */
    public function __construct(StationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $stationId = $this->retrieveRequestParameterStationId($request->attributes);

        if (null === ($station = $this->repository->findByStationId($stationId))) {
            throw StationDoesNotExist::withExternalStationId((string) $stationId);
        }

        $request->attributes->set($configuration->getName(), $station);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return Station::class === $configuration->getClass();
    }

    /**
     * @param ParameterBag $parameters
     *
     * @return UuidInterface
     */
    private function retrieveRequestParameterStationId(ParameterBag $parameters): UuidInterface
    {
        if ($parameters->has(self::STATION_ID_ROUTE_PARAMETER)) {
            return Uuid::fromString($parameters->get(self::STATION_ID_ROUTE_PARAMETER));
        }

        throw new MissingMandatoryParametersException(sprintf(
            'Missing mandatory %s parameters.',
            self::STATION_ID_ROUTE_PARAMETER
        ));
    }
}
