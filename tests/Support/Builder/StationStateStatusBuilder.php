<?php

declare(strict_types=1);

namespace tests\Support\Builder;

use App\Domain\Model\StationState\StationStateStatus;

class StationStateStatusBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $status;

    /**
     * @param string $status
     */
    private function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return StationStateStatusBuilder
     */
    public static function create(): StationStateStatusBuilder
    {
        return new self('OPENED');
    }

    /**
     * @return StationStateStatus
     */
    public function build(): StationStateStatus
    {
        return StationStateStatus::fromString($this->status);
    }

    /**
     * @return StationStateStatusBuilder
     */
    public function withStatusOpened(): StationStateStatusBuilder
    {
        $copy         = $this->copy();
        $copy->status = 'OPENED';

        return $copy;
    }

    /**
     * @return StationStateStatusBuilder
     */
    public function withStatusClosed(): StationStateStatusBuilder
    {
        $copy         = $this->copy();
        $copy->status = 'CLOSED';

        return $copy;
    }

    /**
     * @return StationStateStatusBuilder
     */
    private function copy(): StationStateStatusBuilder
    {
        return new self($this->status);
    }
}
