<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\Form\DataTransformer;

use App\Domain\Model\StationState\StationStateStatus;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StationStateStatusToStringTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if ($value instanceof StationStateStatus) {
            return $value->__toString();
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (null === $value || false === is_string($value)) {
            throw new TransformationFailedException(
                'To reverse transform to a StationStateStatus, "string" type is expected.');
        }

        try {
            return StationStateStatus::fromString($value);
        } catch(\Exception $exception) {
            throw new TransformationFailedException($exception->getMessage());
        }
    }
}
