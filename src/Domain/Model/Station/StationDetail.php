<?php

declare(strict_types=1);

namespace App\Domain\Model\Station;

use App\Domain\Model\ValueObjectInterface;
use Assert\Assert;
use Assert\LazyAssertionException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Information needed to present a station.
 *
 * @ORM\Embeddable()
 */
final class StationDetail implements ValueObjectInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var StationDetailType
     *
     * @ORM\Column(type="enum_station_detail_type_type")
     */
    private $type;

    /**
     * @param string            $name
     * @param StationDetailType $type
     *
     * @throws LazyAssertionException if validate method failed
     */
    private function __construct(string $name, StationDetailType $type)
    {
        $this->validate($name);

        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param string            $name
     * @param StationDetailType $type
     *
     * @return self
     */
    public static function fromRawValues(string $name, StationDetailType $type): self
    {
        return new self($name, $type);
    }

    /**
     * @param string $name
     *
     * @throws LazyAssertionException if at least one assertion is not respected
     */
    private function validate(string $name)
    {
        Assert::lazy()
            ->that($name, 'name')->notEmpty()
            ->verifyNow();
    }
}
