<?php

declare(strict_types=1);

namespace App\Application\UseCase\Filter;

use Assert\Assert;
use Assert\LazyAssertionException;

final class ByIntervalInPeriodFilter
{
    /** @var string */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var string */
    private const VALID_INTERVAL_PATTERN = '/(\d{1,2} minute)|(\d{1,2} hour)|(\d{1,2} day)/';

    /** @var \DateTime */
    private $periodStart;

    /** @var \DateTime */
    private $periodEnd;

    /** @var string */
    private $interval;

    /**
     * @param \DateTime $periodStart
     * @param \DateTime $periodEnd
     * @param string    $interval
     */
    private function __construct(\DateTime $periodStart, \DateTime $periodEnd, string $interval)
    {
        $this->validate($periodStart, $periodEnd, $interval);

        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
        $this->interval = $interval;
    }

    /**
     * @param string $periodStart
     * @param string $periodEnd
     * @param string $interval
     *
     * @return ByIntervalInPeriodFilter
     *
     * @throws LazyAssertionException
     */
    public static function fromRawStringValues(string $periodStart, string $periodEnd, string $interval): self
    {
        Assert::lazy()
            ->that($periodStart, 'periodStart')->date($periodStart, self::DATE_FORMAT)
            ->that($periodEnd, 'periodEnd')->date($periodEnd, self::DATE_FORMAT)
            ->verifyNow();

        return new self(new \DateTime($periodStart), new \DateTime($periodEnd), $interval);
    }

    /**
     * @param \DateTime $periodStart
     * @param \DateTime $periodEnd
     * @param string    $interval
     *
     * @throws LazyAssertionException
     */
    private function validate(\DateTime $periodStart, \DateTime $periodEnd, string $interval): void
    {
        $periodStartTimestamp = $periodStart->getTimestamp();
        $periodEndTimestamp = $periodEnd->getTimestamp();

        Assert::lazy()
            ->that(
                $periodEndTimestamp,
                'periodEnd',
                'PeriodStart can\'t be more recent than PeriodEnd'
            )->greaterThan($periodStartTimestamp)
            ->that($interval, 'interval')->regex(self::VALID_INTERVAL_PATTERN)
            ->verifyNow();
    }

    /**
     * @return string
     */
    public function periodStartAsString(): string
    {
        return $this->periodStart->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function periodEndAsString(): string
    {
        return $this->periodEnd->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function interval(): string
    {
        return $this->interval;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodStart(): \DateTime
    {
        return $this->periodStart;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodEnd(): \DateTime
    {
        return $this->periodEnd;
    }

    /**
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }
}
