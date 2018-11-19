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
    private const LATITUDE_OPTIONS_KEY = 'defaultLatitude';

    /** @var string */
    private const LONGITUDE_OPTIONS_KEY = 'defaultLongitude';

    /** @var string */
    private const LIMIT_OPTIONS_KEY = 'defaultLimit';

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
        $options = $configuration->getOptions();

        $filter = ByGeoLocationFilter::fromRawValues(
            $this->fromQueryOrOptions(self::LATITUDE_QUERY_KEY, $query, self::LATITUDE_OPTIONS_KEY, $options),
            $this->fromQueryOrOptions(self::LONGITUDE_QUERY_KEY, $query, self::LONGITUDE_OPTIONS_KEY, $options),
            $this->fromQueryOrOptions(self::LIMIT_QUERY_KEY, $query, self::LIMIT_OPTIONS_KEY, $options)
        );

        $request->attributes->set($configuration->getName(), $filter);

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
     * @param string       $defaultOptionKey
     * @param array        $options
     *
     * @return float
     */
    private function fromQueryOrOptions(
        string $queryKey,
        ParameterBag $query,
        string $defaultOptionKey,
        array $options
    ): float {
        $value = (float) $query->get($queryKey, $options[$defaultOptionKey] ?? null);

        Assert::that($value)
            ->float(self::EXCEPTION_MESSAGE)
            ->greaterThan(0, self::EXCEPTION_MESSAGE);

        return $value;
    }
}
