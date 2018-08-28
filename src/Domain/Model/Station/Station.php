<?php

declare(strict_types=1);

namespace App\Domain\Model\Station;

use App\Domain\Model\AggregateInterface;
use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationState;
use App\Domain\Model\StationState\StationStateStatus;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * An aggregate of station data to represent a Station Model.
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     uniqueConstraints={@ORM\UniqueConstraint(
 *         name="unique_station_external_external_station_id",
 *         columns={"station_external_data_external_station_id"}
 *     )}
 * )
 */
final class Station implements AggregateInterface
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private $stationId;

    /**
     * @var StationDetail
     *
     *
     * @ORM\Embedded(class="App\Domain\Model\Station\StationDetail")
     */
    private $stationDetail;

    /**
     * @var StationExternalData
     *
     * @ORM\Embedded(class="App\Domain\Model\Station\StationExternalData")
     */
    private $stationExternalData;

    /**
     * @var Location
     *
     * @ORM\Embedded(class="App\Domain\Model\Station\Location")
     */
    private $location;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
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
     * @param UuidInterface           $stationId
     * @param StationDetail           $stationDetail
     * @param StationExternalData     $stationExternalData
     * @param Location                $location
     * @param \DateTimeImmutable      $createdAt
     * @param \DateTimeImmutable|null $updatedAt
     *
     * @return self
     */
    public static function create(
        UuidInterface $stationId,
        StationDetail $stationDetail,
        StationExternalData $stationExternalData,
        Location $location,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt = null): self
    {
        return new self(
            $stationId,
            $stationDetail,
            $stationExternalData,
            $location,
            $createdAt,
            $updatedAt
        );
    }

    /**
     * @return UuidInterface
     */
    public function stationId(): UuidInterface
    {
        return $this->stationId;
    }

    /**
     * @return string
     */
    public function externalStationId(): string
    {
        return $this->stationExternalData->externalStationId();
    }

    /**
     * @param DateTimeImmutableStringable $statedAt
     * @param int                         $availableBikeNumber
     * @param int                         $availableSlotNumber
     * @param StationStateStatus          $status
     * @param \DateTimeImmutable          $createdAt
     *
     * @return StationState
     */
    public function assignStationState(
        DateTimeImmutableStringable $statedAt,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status,
        \DateTimeImmutable $createdAt): StationState
    {
        return StationState::create(
            $statedAt,
            $this,
            $availableBikeNumber,
            $availableSlotNumber,
            $status,
            $createdAt
        );
    }
}
