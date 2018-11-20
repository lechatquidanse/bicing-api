<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Assert\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
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

        if (null === ($latitude = $query->get(self::LATITUDE_QUERY_KEY))
            || null === ($longitude = $query->get(self::LONGITUDE_QUERY_KEY))
            || null === ($limit = $query->get(self::LIMIT_QUERY_KEY))) {
            return false;
        }

        $this->validateQueries($latitude, $longitude, $limit);

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
     * @param $latitude
     * @param $longitude
     * @param $limit
     */
    private function validateQueries($latitude, $longitude, $limit): void
    {
        Assert::lazy()
            ->that($latitude, 'latitude')->nullOr()->float()->greaterThan(0)
            ->that($longitude, 'longitude')->nullOr()->float()->greaterThan(0)
            ->that($limit, 'limit')->nullOr()->float()->greaterThan(0)
            ->verifyNow();
    }
}
