<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use JMS\Serializer\Annotation as Serializer;
use App\Domain\Model\StationState\StationStateStatus;

final class Availability
{
    /** @var array */
    private const STATUS_FORMATTER = [
        0 => StationStateStatus::STATUS_CLOSED,
        1 => StationStateStatus::STATUS_OPENED,
    ];

    /**
     * @Serializer\Type("int")
     *
     * @var int
     */
    private $bikes;

    /**
     * @Serializer\Type("int")
     *
     * @var int
     */
    private $slots;

    /**
     * @Serializer\Accessor(setter="statusToDomainStatus")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $status;

    /**
     * @param int    $bikes
     * @param int    $slots
     * @param string $status
     */
    private function __construct(int $bikes, int $slots, string $status)
    {
        $this->bikes = $bikes;
        $this->slots = $slots;
        $this->status = $status;
    }

    /**
     * @param int    $bikes
     * @param int    $slots
     * @param string $status
     *
     * @return Availability
     */
    public static function fromRawValues(int $bikes, int $slots, string $status): Availability
    {
        return new self($bikes, $slots, $status);
    }

    /**
     * @param int $status
     */
    public function statusToDomainStatus(int $status): void
    {
        if (isset(self::STATUS_FORMATTER[$status])) {
            $this->status = self::STATUS_FORMATTER[$status];
        } else {
            $this->status = StationStateStatus::STATUS_CLOSED;
        }
    }

    /**
     * @return int
     */
    public function bikes(): int
    {
        return $this->bikes;
    }

    /**
     * @return int
     */
    public function slots(): int
    {
        return $this->slots;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }
}
