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
    private const QUERY_VALIDATE_PATTERN = '/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?),([0-9]*[.])?[0-9]+$/'; // phpcs:ignore

    /** @var string */
    private const QUERY_KEY = 'geo_location_filter';

    /** @var string */
    private const EXCEPTION_MESSAGE = 'Value "%s" does not match expected expression (for example: \'?geo_location_filter=41.373,2.17031,450.35\').'; // phpcs:ignore

    /**
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $query = $request->query;

        if (null === ($geoLocation = $query->get(self::QUERY_KEY))) {
            return false;
        }

        list($latitude, $longitude, $limit) = $this->extractGeoLocationValuesFromQuery(
            $this->validateGeoLocation($geoLocation)
        );

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
     * @param string $geoLocation
     *
     * @return string
     */
    private function validateGeoLocation(string $geoLocation): string
    {
        Assert::that($geoLocation)->regex(self::QUERY_VALIDATE_PATTERN, sprintf(self::EXCEPTION_MESSAGE, $geoLocation));

        return $geoLocation;
    }

    /**
     * @param string $query
     *
     * @return array
     */
    private function extractGeoLocationValuesFromQuery(string $query): array
    {
        return array_map('floatval', explode(',', $query));
    }
}
