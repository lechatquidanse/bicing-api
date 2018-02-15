<?php

declare(strict_types=1);

namespace App\Domain\Model\Station;

use App\Domain\Exception\Station\StationDetailTypeIsInvalidException;
use App\Domain\Model\ValueObjectInterface;

final class StationDetailType implements ValueObjectInterface
{
    /**
     * @var string
     */
    const TYPE_BIKE = 'BIKE';

    /**
     * @var string
     */
    const TYPE_BIKE_ELECTRIC = 'ELECTRIC_BIKE';

    /**
     * @var array
     */
    const TYPES_ALLOWED = [
        self::TYPE_BIKE,
        self::TYPE_BIKE_ELECTRIC,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    private function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $string
     *
     * @return StationDetailType
     */
    public static function fromString(string $string): StationDetailType
    {
        if (self::TYPE_BIKE === $string) {
            return new self(self::TYPE_BIKE);
        } elseif (self::TYPE_BIKE_ELECTRIC === $string) {
            return new self(self::TYPE_BIKE_ELECTRIC);
        }

        throw StationDetailTypeIsInvalidException::withType($string);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->type;
    }
}
