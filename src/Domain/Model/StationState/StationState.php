<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

use App\Domain\Model\Station\Station;
use App\Domain\Model\ValueObjectInterface;
use Assert\Assert;
use Assert\LazyAssertionException;
use Doctrine\ORM\Mapping as ORM;

/**
 * A state of a station at a statedAt time.
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class StationState implements ValueObjectInterface
{
    /**
     * @var DateTimeImmutableStringable
     *
     * @ORM\Id()
     * @ORM\Column(type="date_time_immutable_stringable")
     */
    private $statedAt;

    /**
     * @var Station
     *
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Station\Station")
     * @ORM\JoinColumn(name="station_assigned_id", referencedColumnName="station_id")
     */
    private $stationAssigned;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned":true})
     */
    private $availableBikeNumber;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned":true})
     */
    private $availableSlotNumber;

    /**
     * @var StationStateStatus
     *
     * @ORM\Column(type="enum_station_state_status_type")
     */
    private $status;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
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
    private function __construct(
        DateTimeImmutableStringable $statedAt,
        Station $stationAssigned,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status,
        \DateTimeImmutable $createdAt
    ) {
        $this->validate($availableBikeNumber, $availableSlotNumber);

        $this->statedAt = $statedAt;
        $this->stationAssigned = $stationAssigned;
        $this->availableBikeNumber = $availableBikeNumber;
        $this->availableSlotNumber = $availableSlotNumber;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTimeImmutableStringable $statedAt
     * @param Station                     $stationAssigned
     * @param int                         $availableBikeNumber
     * @param int                         $availableSlotNumber
     * @param StationStateStatus          $status
     * @param \DateTimeImmutable          $createdAt
     *
     * @return self
     */
    public static function create(
        DateTimeImmutableStringable $statedAt,
        Station $stationAssigned,
        int $availableBikeNumber,
        int $availableSlotNumber,
        StationStateStatus $status,
        \DateTimeImmutable $createdAt
    ): self {
        return new self($statedAt, $stationAssigned, $availableBikeNumber, $availableSlotNumber, $status, $createdAt);
    }

    /**
     * @param int $availableBikeNumber
     * @param int $availableSlotNumber
     *
     * @throws LazyAssertionException if at least one assertion is not respected
     */
    public function validate(int $availableBikeNumber, int $availableSlotNumber)
    {
        Assert::lazy()
            ->that($availableBikeNumber, 'availableBikeNumber')->min(0)
            ->that($availableSlotNumber, 'availableSlotNumber')->min(0)
            ->verifyNow();
    }

    /**
     * @return DateTimeImmutableStringable
     */
    public function statedAt(): DateTimeImmutableStringable
    {
        return $this->statedAt;
    }

    /**
     * @return Station
     */
    public function stationAssigned(): Station
    {
        return $this->stationAssigned;
    }
}
