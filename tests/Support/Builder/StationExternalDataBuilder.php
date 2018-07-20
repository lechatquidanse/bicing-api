<?php

declare(strict_types=1);

namespace tests\Support\Builder;


use App\Domain\Model\Station\StationExternalData;

class StationExternalDataBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $externalStationId;

    /**
     * @var array
     */
    private $nearByExternalStationIds;

    /**
     * @param string $externalStationId
     * @param array  $nearByExternalStationIds
     */
    private function __construct(string $externalStationId, array $nearByExternalStationIds)
    {
        $this->externalStationId        = $externalStationId;
        $this->nearByExternalStationIds = $nearByExternalStationIds;
    }

    /**
     * {@inheritdoc}
     *
     * @return StationExternalDataBuilder
     */
    public static function create(): StationExternalDataBuilder
    {
        return new self('34', ['36', '105', '359', '380']);
    }

    /**
     * {@inheritdoc}
     *
     * @return StationExternalData
     */
    public function build(): StationExternalData
    {
        return StationExternalData::fromRawValues(
            $this->externalStationId,
            $this->nearByExternalStationIds
        );
    }

    /**
     * @param string $externalStationId
     *
     * @return StationExternalDataBuilder
     */
    public function withExternalStationId(string $externalStationId): StationExternalDataBuilder
    {
        $copy                    = $this->copy();
        $copy->externalStationId = $externalStationId;

        return $copy;
    }

    /**
     * @param array $nearByExternalStationIds
     *
     * @return StationExternalDataBuilder
     */
    public function withNearByExternalStationIds(array $nearByExternalStationIds): StationExternalDataBuilder
    {
        $copy                           = $this->copy();
        $copy->nearByExternalStationIds = $nearByExternalStationIds;

        return $copy;
    }

    /**
     * @return StationExternalDataBuilder
     */
    private function copy(): StationExternalDataBuilder
    {
        return new self(
            $this->externalStationId,
            $this->nearByExternalStationIds
        );
    }
}
