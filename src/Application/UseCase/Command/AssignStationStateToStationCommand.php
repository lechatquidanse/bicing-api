<?php

declare(strict_types=1);

namespace App\Application\UseCase\Command;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Domain\Model\StationState\StationStateStatus;
use App\Domain\Model\UseCase;

final class AssignStationStateToStationCommand implements UseCase
{
    /**
     * @var DateTimeImmutableStringable
     */
    public $statedAt;

    /**
     * @var string
     */
    public $externalStationId;

    /**
     * @var int
     */
    public $availableBikeNumber;

    /**
     * @var int
     */
    public $availableSlotNumber;

    /**
     * @var StationStateStatus
     */
    public $status;

    /**
     * @var \DateTimeImmutable
     */
    public $createdAt;
}
