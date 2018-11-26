<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Symfony;

use App\Application\UseCase\Filter\ByIntervalInPeriodFilter;
use Psr\Log\LoggerAwareTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class SymfonyByIntervalInPeriodFilterParamConverter implements ParamConverterInterface
{
    use LoggerAwareTrait;

    /** @var string */
    private const DATE_START_QUERY_KEY = 'periodStart';

    /** @var string */
    private const DATE_END_QUERY_KEY = 'periodEnd';

    /** @var string */
    private const INTERVAL_QUERY_KEY = 'interval';

    /** @var string */
    private const DATE_START_OPTIONS_KEY = 'defaultPeriodStart';

    /** @var string */
    private const DATE_END_OPTIONS_KEY = 'defaultPeriodEnd';

    /** @var string */
    private const INTERVAL_OPTIONS_KEY = 'defaultInterval';

    /** @var string */
    private const EXCEPTION_DATE_OPTION_MESSAGE = 'An error occurred during period creation from options values %s';

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

        $filter = ByIntervalInPeriodFilter::fromRawStringValues(
            $this->dateFromQueryOrOptions($query, self::DATE_START_QUERY_KEY, $options, self::DATE_START_OPTIONS_KEY),
            $this->dateFromQueryOrOptions($query, self::DATE_END_QUERY_KEY, $options, self::DATE_END_OPTIONS_KEY),
            $this->intervalFromQueryAndOptions($query, $options)
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
        return ByIntervalInPeriodFilter::class === $configuration->getClass();
    }

    /**
     * @param string $message
     */
    private function logError(string $message): void
    {
        if (null !== $this->logger) {
            $this->logger->error($message);
        }
    }

    /**
     * @param ParameterBag $query
     * @param string       $queryKey
     * @param array        $options
     * @param string       $optionsKey
     *
     * @return string
     */
    private function dateFromQueryOrOptions(
        ParameterBag $query,
        string $queryKey,
        array $options,
        string $optionsKey
    ): string {
        try {
            $defaultOption = isset($options[$optionsKey]) ?
                (new \DateTime($options[$optionsKey]))->format(ByIntervalInPeriodFilter::DATE_FORMAT) :
                '';
        } catch (\Exception $exception) {
            $defaultOption = '';
            $this->logError(sprintf(self::EXCEPTION_DATE_OPTION_MESSAGE, $optionsKey));
        }

        return $query->get($queryKey, $defaultOption);
    }

    /**
     * @param ParameterBag $query
     * @param array        $options
     *
     * @return string
     */
    private function intervalFromQueryAndOptions(ParameterBag $query, array $options): string
    {
        return $query->get(self::INTERVAL_QUERY_KEY, $options[self::INTERVAL_OPTIONS_KEY] ?? '');
    }
}
