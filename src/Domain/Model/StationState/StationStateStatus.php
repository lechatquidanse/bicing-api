<?php

declare(strict_types=1);

namespace App\Domain\Model\StationState;

use App\Domain\Exception\StationState\StationStateStatusIsInvalidException;
use App\Domain\Model\ValueObjectInterface;

final class StationStateStatus implements ValueObjectInterface
{
    /**
     * @var string
     */
    const STATUS_OPENED = 'OPENED';

    /**
     * @var string
     */
    const STATUS_CLOSED = 'CLOSED';

    /**
     * @var array
     */
    const STATUS_ALLOWED = [
        self::STATUS_OPENED,
        self::STATUS_CLOSED,
    ];

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
     * @param string $string
     *
     * @return StationStateStatus
     */
    public static function fromString(string $string): StationStateStatus
    {
        if (in_array($string, ['CLS', self::STATUS_CLOSED])) {
            return new self(self::STATUS_CLOSED);
        }

        if (in_array($string, ['OPN', self::STATUS_OPENED])) {
            return new self(self::STATUS_OPENED);
        }

        throw StationStateStatusIsInvalidException::withStatus($string);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->status;
    }
}
