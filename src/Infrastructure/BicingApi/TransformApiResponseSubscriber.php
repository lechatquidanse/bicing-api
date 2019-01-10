<?php

declare(strict_types=1);

namespace App\Infrastructure\BicingApi;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\Exception\RuntimeException;

final class TransformApiResponseSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeSerialize',
                'class' => AvailabilityStation::class,
                'format' => 'json',
            ],
        ];
    }

    public function onPreDeSerialize(PreDeserializeEvent $event): void
    {
        $data = $event->getData();

        if (false === is_array($data)) {
            throw new RuntimeException('An error occurred during bicing API deserialization');
        }

        $event->setData(array_merge($data, [
            'availability' => $data,
            'station' => $data,
            'location' => $data,
        ]));
    }
}
