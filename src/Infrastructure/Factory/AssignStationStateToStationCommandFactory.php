<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Application\UseCase\Command\AssignStationStateToStationCommandFactoryInterface;
use App\Infrastructure\BicingApi\AvailabilityStation;
use App\Infrastructure\Factory\Form\Symfony\Type\SymfonyAssignStationStateToStationType;
use App\Infrastructure\System\ClockInterface;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormFactoryInterface;

final class AssignStationStateToStationCommandFactory implements AssignStationStateToStationCommandFactoryInterface
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
     * @return AssignStationStateToStationCommand
     *
     * @throws InvalidArgumentException
     */
    public function fromAvailabilityStation(
        AvailabilityStation $availabilityStation
    ): AssignStationStateToStationCommand {
        $form = $this->formFactory->create(SymfonyAssignStationStateToStationType::class);

        $form->submit([
            'externalStationId' => $availabilityStation->id(),
            'availableBikeNumber' => $availabilityStation->availability()->bikes(),
            'availableSlotNumber' => $availabilityStation->availability()->slots(),
            'status' => $availabilityStation->availability()->status(),
        ]);

        if (!$form->isValid()) {
            throw new InvalidArgumentException('Form invalid when creating AssignStationStateToStationCommand.');
        }

        $command = $form->getData();

        $command->createdAt = $this->clock->dateTimeImmutable();

        return $command;
    }
}
