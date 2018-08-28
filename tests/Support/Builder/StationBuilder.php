<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\Station\Location;
use App\Domain\Model\Station\Station;
use App\Domain\Model\Station\StationDetail;
use App\Domain\Model\Station\StationExternalData;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class StationBuilder implements BuilderInterface
{
    /**
     * @var UuidInterface
     */
    private $stationId;

    /**
     * @var StationDetail
     */
    private $stationDetail;

    /**
     * @var StationExternalData
     */
    private $stationExternalData;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable|null
     */
    private $updatedAt;

    /**
     * @param UuidInterface           $stationId
     * @param StationDetail           $stationDetail
     * @param StationExternalData     $stationExternalData
     * @param Location                $location
     * @param \DateTimeImmutable      $createdAt
     * @param \DateTimeImmutable|null $updatedAt
     */
    private function __construct(
        UuidInterface $stationId,
        StationDetail $stationDetail,
        StationExternalData $stationExternalData,
        Location $location,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt = null)
    {
        $this->stationId = $stationId;
        $this->stationDetail = $stationDetail;
        $this->stationExternalData = $stationExternalData;
        $this->location = $location;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * {@inheritdoc}
     *
     * @return StationBuilder
     */
    public static function create(): StationBuilder
    {
        return new self(
            Uuid::uuid4(),
            StationDetailBuilder::create()->build(),
            StationExternalDataBuilder::create()->build(),
            LocationBuilder::create()->build(),
            new \DateTimeImmutable(),
            null
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return Station
     */
    public function build(): Station
    {
        return Station::create(
            $this->stationId,
            $this->stationDetail,
            $this->stationExternalData,
            $this->location,
            $this->createdAt,
            $this->updatedAt
        );
    }

    /**
     * @param UuidInterface $stationId
     *
     * @return StationBuilder
     */
    public function withStationId(UuidInterface $stationId): StationBuilder
    {
        $copy = $this->copy();
        $copy->stationId = $stationId;

        return $copy;
    }

    /**
     * @param StationDetail $stationDetail
     *
     * @return StationBuilder
     */
    public function withStationDetail(StationDetail $stationDetail): StationBuilder
    {
        $copy = $this->copy();
        $copy->stationDetail = $stationDetail;

        return $copy;
    }

    /**
     * @param StationExternalData $stationExternalData
     *
     * @return StationBuilder
     */
    public function withStationExternalData(StationExternalData $stationExternalData): StationBuilder
    {
        $copy = $this->copy();
        $copy->stationExternalData = $stationExternalData;

        return $copy;
    }

    /**
     * @param Location $location
     *
     * @return StationBuilder
     */
    public function withLocation(Location $location): StationBuilder
    {
        $copy = $this->copy();
        $copy->location = $location;

        return $copy;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     *
     * @return StationBuilder
     */
    public function withCreatedAt(\DateTimeImmutable $createdAt): StationBuilder
    {
        $copy = $this->copy();
        $copy->createdAt = $createdAt;

        return $copy;
    }

    /**
     * @param \DateTimeImmutable|null $updatedAt
     *
     * @return StationBuilder
     */
    public function withUpdatedAt(?\DateTimeImmutable $updatedAt): StationBuilder
    {
        $copy = $this->copy();
        $copy->updatedAt = $updatedAt;

        return $copy;
    }

    /**
     * @return StationBuilder
     */
    private function copy(): StationBuilder
    {
        return new self(
            $this->stationId,
            $this->stationDetail,
            $this->stationExternalData,
            $this->location,
            $this->createdAt,
            $this->updatedAt
        );
    }
}
