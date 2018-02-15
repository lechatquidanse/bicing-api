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
     * @var string|null
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $addressNumber;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned":true})
     */
    private $districtCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5)
     */
    private $zipCode;

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
     * @param string $address
     * @param int    $districtCode
     * @param string $zipCode
     * @param float  $latitude
     * @param float  $longitude
     */
    private function __construct(
        string $address,
        int $districtCode,
        string $zipCode,
        float $latitude,
        float $longitude)
    {
        $this->validate($address, $districtCode, $zipCode);

        $this->address       = $address;
        $this->districtCode  = $districtCode;
        $this->zipCode       = $zipCode;
        $this->latitude      = $latitude;
        $this->longitude     = $longitude;
    }

    /**
     * @param string $address
     * @param int    $districtCode
     * @param string $zipCode
     * @param float  $latitude
     * @param float  $longitude
     *
     * @return self
     */
    public static function fromRawValues(
        string $address,
        int $districtCode,
        string $zipCode,
        float $latitude,
        float $longitude): self
    {
        return new self(
            $address,
            $districtCode,
            $zipCode,
            $latitude,
            $longitude);
    }

    /**
     * @param string $addressNumber
     */
    public function withAddressNumber(string $addressNumber)
    {
        $this->validateAddressNumber($addressNumber);

        $this->addressNumber = $addressNumber;
    }

    /**
     * @param string $address
     * @param int    $districtCode
     * @param string $zipCode
     *
     * @throws LazyAssertionException if at least one assertion is not respected.
     */
    private function validate(string $address, int $districtCode, string $zipCode): void
    {
        Assert::lazy()
            ->that($address, 'address')->notEmpty()
            ->that($districtCode, 'districtCode')->max(10)
            ->that($zipCode, 'zipCode')->length(5)
            ->verifyNow();
    }

    /**
     * @param string $addressNumber
     */
    private function validateAddressNumber(string $addressNumber)
    {
        Assertion::maxLength($addressNumber, 10);
    }
}
