<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\Station\StationDetailType;

class StationDetailTypeBuilder implements BuilderInterface
{
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
     * @return StationDetailTypeBuilder
     */
    public static function create(): StationDetailTypeBuilder
    {
        return new self('BIKE');
    }

    /**
     * @return StationDetailType
     */
    public function build(): StationDetailType
    {
        return StationDetailType::fromString($this->type);
    }

    /**
     * @return StationDetailTypeBuilder
     */
    public function withTypeBike(): StationDetailTypeBuilder
    {
        $copy       = $this->copy();
        $copy->type = 'BIKE';

        return $copy;
    }

    /**
     * @return StationDetailTypeBuilder
     */
    public function withTypeElectricBike(): StationDetailTypeBuilder
    {
        $copy       = $this->copy();
        $copy->type = 'ELECTRIC_BIKE';

        return $copy;
    }

    /**
     * @return StationDetailTypeBuilder
     */
    private function copy(): StationDetailTypeBuilder
    {
        return new self($this->type);
    }
}
