<?php

declare(strict_types=1);

namespace App\Domain\Model\Station;

use App\Domain\Model\ValueObjectInterface;
use Assert\Assert;
use Assert\Assertion;
use Assert\LazyAssertionException;
use Doctrine\ORM\Mapping as ORM;

/**
 * A geo location information.
 *
 * @ORM\Embeddable()
 */
final class Location implements ValueObjectInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $addressNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $zipCode;

    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", options={"unsigned":true}, nullable=true)
     */
    private $districtCode;

    /**
     * @var string
     *
     * @ORM\Column(type="geometry", options={"geometry_type"="POINT"}, nullable=true)
     */
    private $geometry;

    /**
     * @param string      $address
     * @param float       $latitude
     * @param float       $longitude
     * @param string|null $addressNumber
     * @param int|null    $districtCode
     * @param string|null $zipCode
     */
    private function __construct(
        string $address,
        float $latitude,
        float $longitude,
        ?string $addressNumber,
        ?int $districtCode,
        ?string $zipCode
    ) {
        $this->validate($address, $addressNumber, $districtCode, $zipCode);

        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->addressNumber = $addressNumber;
        $this->districtCode = $districtCode;
        $this->zipCode = $zipCode;
    }

    /**
     * @param string      $address
     * @param float       $latitude
     * @param float       $longitude
     * @param string|null $addressNumber
     * @param int|null    $districtCode
     * @param string|null $zipCode
     *
     * @return Location
     */
    public static function fromRawValues(
        string $address,
        float $latitude,
        float $longitude,
        ?string $addressNumber,
        ?int $districtCode,
        ?string $zipCode
    ): self {
        return new self(
            $address,
            $latitude,
            $longitude,
            $addressNumber,
            $districtCode,
            $zipCode
        );
    }

    /**
     * @param string      $address
     * @param string|null $addressNumber
     * @param int|null    $districtCode
     * @param string|null $zipCode
     *
     * @throws LazyAssertionException if at least one assertion is not respected
     */
    private function validate(string $address, ?string $addressNumber, ?int $districtCode, ?string $zipCode): void
    {
        Assert::lazy()
            ->that($address, 'address')->notEmpty()
            ->that($addressNumber, 'address')->nullOr()->maxLength(10)
            ->that($districtCode, 'districtCode')->nullOr()->max(10)
            ->that($zipCode, 'zipCode')->nullOr()->length(5)
            ->verifyNow();
    }
}
