<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\Station\StationDetail;
use App\Domain\Model\Station\StationDetailType;

class StationDetailBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var StationDetailType
     */
    private $type;

    /**
     * @param string            $name
     * @param StationDetailType $type
     */
    private function __construct(string $name, StationDetailType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     *
     * @return StationDetailBuilder
     */
    public static function create(): StationDetailBuilder
    {
        return new self(
            '35 - C/ SANT RAMON DE PENYAFORT',
            StationDetailTypeBuilder::create()->build()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return StationDetail
     */
    public function build(): StationDetail
    {
        return StationDetail::fromRawValues(
            $this->name,
            $this->type
        );
    }

    /**
     * @param string $name
     *
     * @return StationDetailBuilder
     */
    public function withName(string $name): StationDetailBuilder
    {
        $copy = $this->copy();
        $copy->name = $name;

        return $copy;
    }

    /**
     * @param StationDetailType $type
     *
     * @return StationDetailBuilder
     */
    public function withType(StationDetailType $type): StationDetailBuilder
    {
        $copy = $this->copy();
        $copy->type = $type;

        return $copy;
    }

    /**
     * @return StationDetailBuilder
     */
    private function copy(): self
    {
        return new self(
            $this->name,
            $this->type
        );
    }
}
