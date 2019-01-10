<?php

declare(strict_types=1);

namespace tests\Support\Builder\BicingApi;

use App\Domain\Model\StationState\StationStateStatus;
use App\Infrastructure\BicingApi\Availability;
use tests\Support\Builder\BuilderInterface;

final class AvailabilityBuilder implements BuilderInterface
{
    /** @var int */
    private $bikes;

    /** @var int */
    private $slots;

    /** @var string */
    private $status;

    /**
     * @param int    $bikes
     * @param int    $slots
     * @param string $status
     */
    public function __construct(int $bikes, int $slots, string $status)
    {
        $this->bikes = $bikes;
        $this->slots = $slots;
        $this->status = $status;
    }

    public static function create(): AvailabilityBuilder
    {
        return new self(
            random_int(0, 30),
            random_int(0, 30),
            StationStateStatus::STATUS_OPENED
        );
    }

    public function build()
    {
        return Availability::fromRawValues($this->bikes, $this->slots, $this->status);
    }

    public function withBikes(int $bikes): AvailabilityBuilder
    {
        $copy = $this->copy();
        $copy->bikes = $bikes;

        return $copy;
    }

    public function withSlots(int $slots): AvailabilityBuilder
    {
        $copy = $this->copy();
        $copy->slots = $slots;

        return $copy;
    }

    public function withStatus(string $status): AvailabilityBuilder
    {
        $copy = $this->copy();
        $copy->status = $status;

        return $copy;
    }

    private function copy(): AvailabilityBuilder
    {
        return new self($this->bikes, $this->slots, $this->status);
    }
}
