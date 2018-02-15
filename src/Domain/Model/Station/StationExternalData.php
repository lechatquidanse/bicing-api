<?php

declare(strict_types=1);

namespace App\Domain\Model\Station;

use App\Domain\Model\ValueObjectInterface;
use Assert\Assert;
use Assert\LazyAssertionException;
use Doctrine\ORM\Mapping as ORM;

/**
 * External data link to a station.
 *
 * It stores data used by the company owner of this station.
 *
 * @ORM\Embeddable()
 */
final class StationExternalData implements ValueObjectInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $externalStationId;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array")
     */
    private $nearByExternalStationIds;

    /**
     * @param string $externalStationId
     * @param array  $nearByExternalStationIds
     */
    private function __construct(string $externalStationId, array $nearByExternalStationIds)
    {
        $this->validate($externalStationId);

        $this->externalStationId        = $externalStationId;
        $this->nearByExternalStationIds = $nearByExternalStationIds;
    }

    /**
     * @param string $externalStationId
     * @param array  $nearByExternalStationIds
     *
     * @return self
     */
    public static function fromRawValues(string $externalStationId, array $nearByExternalStationIds): self
    {
        return new self($externalStationId, $nearByExternalStationIds);
    }

    /**
     * @param string $externalStationId
     *
     * @throws LazyAssertionException if at least one assertion is not respected.
     */
    private function validate(string $externalStationId)
    {
        Assert::lazy()
            ->that($externalStationId, 'externalStationId')->notEmpty()
            ->verifyNow();
    }

    /**
     * @return string
     */
    public function externalStationId(): string
    {
        return $this->externalStationId;
    }
}

