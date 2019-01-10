<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Application\UseCase\Command\CreateStationCommandFactoryInterface;
use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\Factory\Form\Symfony\Type\SymfonyCreateStationType;
use App\Infrastructure\System\ClockInterface;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormFactoryInterface;

final class CreateStationCommandFactory implements CreateStationCommandFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ClockInterface
     */
    private $clock;

    /**
     * @param FormFactoryInterface $formFactory
     * @param ClockInterface       $clock
     */
    public function __construct(FormFactoryInterface $formFactory, ClockInterface $clock)
    {
        $this->formFactory = $formFactory;
        $this->clock = $clock;
    }

    /**
     * @param AvailabilityStation $availabilityStation
     *
     * @return CreateStationCommand
     *
     * @throws InvalidArgumentException
     */
    public function fromAvailabilityStation(AvailabilityStation $availabilityStation): CreateStationCommand
    {
        $form = $this->formFactory->create(SymfonyCreateStationType::class);

        $form->submit([
            'name' => $availabilityStation->station()->name(),
            'type' => $availabilityStation->station()->type(),
            'externalStationId' => $availabilityStation->id(),
            'nearByExternalStationIds' => $availabilityStation->station()->nearByStationIds(),
            'address' => $availabilityStation->location()->address(),
            'addressNumber' => $availabilityStation->location()->addressNumber(),
            'districtCode' => $availabilityStation->location()->districtCode(),
            'zipCode' => $availabilityStation->location()->zipCode(),
            'latitude' => $availabilityStation->location()->latitude(),
            'longitude' => $availabilityStation->location()->longitude(),
        ]);

        if (!$form->isValid()) {
            throw new InvalidArgumentException('Form invalid when creating CreateStationCommand.');
        }

        $command = $form->getData();

        $command->createdAt = $this->clock->dateTimeImmutable();

        return $command;
    }
}
