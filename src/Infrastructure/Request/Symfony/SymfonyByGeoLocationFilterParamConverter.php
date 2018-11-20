<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Assert\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class SymfonyByGeoLocationFilterParamConverter implements ParamConverterInterface
{
    /** @var string */
    private const LATITUDE_QUERY_KEY = 'latitude';

    /** @var string */
    private const LONGITUDE_QUERY_KEY = 'longitude';

    /** @var string */
    private const LIMIT_QUERY_KEY = 'limit';

    /** @var string */
    private const EXCEPTION_MESSAGE = 'An error occurred during geo location creation from queries values';

    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $query = $request->query;

        if (null === ($latitude = $this->fromQuery(self::LATITUDE_QUERY_KEY, $query))
            || null === ($longitude = $this->fromQuery(self::LONGITUDE_QUERY_KEY, $query))
            || null === ($limit = $this->fromQuery(self::LIMIT_QUERY_KEY, $query))) {
            return false;
        }

        $request->attributes->set($configuration->getName(), ByGeoLocationFilter::fromRawValues(
            $latitude,
            $longitude,
            $limit
        ));

        return true;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return ByGeoLocationFilter::class === $configuration->getClass();
    }

    /**
     * @param string       $queryKey
     * @param ParameterBag $query
     *
     * @return float|null
     */
    private function fromQuery(string $queryKey, ParameterBag $query): ?float
    {
        $value = (float) $query->get($queryKey, null);

        Assert::that($value)
            ->nullOr()
            ->float(self::EXCEPTION_MESSAGE)
            ->greaterThan(0, self::EXCEPTION_MESSAGE);

        return $value;
    }
}
