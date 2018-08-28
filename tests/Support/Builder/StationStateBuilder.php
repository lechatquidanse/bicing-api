<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\Station\Station;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateStatus;

class StationStateBuilder implements BuilderInterface
{
    /**
     * @var DateTimeImmutableStringable
     */
    private $statedAt;

    /**
     * @var Station
     */
    private $stationAssigned;

    /**
     * @var int
     */
    private $availableBikeNumber;

    /**
     * @var int
     */
    private $availableSlotNumber;

    /**
     * @var StationStateStatus
     */
    private $status;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param DateTimeImmutableStringable $statedAt
     * @param Station                     $stationAssigned
     * @param int                         $availableBikeNumber
     * @param int                         $availableSlotNumber
     * @param StationStateStatus          $status
     * @param \DateTimeImmutable          $createdAt
     */
    public function __construct(
        DateTimeImmutableStringable $statedAt,
        Station $stationAssigned,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status,
        \DateTimeImmutable $createdAt)
    {
        $this->statedAt = $statedAt;
        $this->stationAssigned = $stationAssigned;
        $this->availableBikeNumber = $availableBikeNumber;
        $this->availableSlotNumber = $availableSlotNumber;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     *
     * @return StationStateBuilder
     */
    public static function create(): StationStateBuilder
    {
        return new self(
            new DateTimeImmutableStringable(),
            StationBuilder::create()->build(),
            12,
            8,
            StationStateStatusBuilder::create()->build(),
            new \DateTimeImmutable()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return StationState
     */
    public function build(): StationState
    {
        return StationState::create(
            $this->statedAt,
            $this->stationAssigned,
            $this->availableBikeNumber,
            $this->availableSlotNumber,
            $this->status,
            $this->createdAt
        );
    }

    /**
     * @param DateTimeImmutableStringable $statedAt
     *
     * @return StationStateBuilder
     */
    public function withStatedAt(DateTimeImmutableStringable $statedAt): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->statedAt = $statedAt;

        return $copy;
    }

    /**
     * @param Station $stationAssigned
     *
     * @return StationStateBuilder
     */
    public function withStationAssigned(Station $stationAssigned): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->stationAssigned = $stationAssigned;

        return $copy;
    }

    /**
     * @param int $availableBikeNumber
     *
     * @return StationStateBuilder
     */
    public function withAvailableBikeNumber(int $availableBikeNumber): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->availableBikeNumber = $availableBikeNumber;

        return $copy;
    }

    /**
     * @param int $availableSlotNumber
     *
     * @return StationStateBuilder
     */
    public function withAvailableSlotNumber(int $availableSlotNumber): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->availableSlotNumber = $availableSlotNumber;

        return $copy;
    }

    /**
     * @param StationStateStatus $status
     *
     * @return StationStateBuilder
     */
    public function withStatus(StationStateStatus $status): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->status = $status;

        return $copy;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     *
     * @return StationStateBuilder
     */
    public function withCreatedAt(\DateTimeImmutable $createdAt): StationStateBuilder
    {
        $copy = $this->copy();
        $copy->createdAt = $createdAt;

        return $copy;
    }

    /**
     * @return StationStateBuilder
     */
    private function copy(): StationStateBuilder
    {
        return new self(
            $this->statedAt,
            $this->stationAssigned,
            $this->availableBikeNumber,
            $this->availableSlotNumber,
            $this->status,
            $this->createdAt
        );
    }
}
