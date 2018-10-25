<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\Form\Symfony\Type;

use App\Application\UseCase\Command\AssignStationStateToStationCommand;
use App\Infrastructure\Factory\Form\DataTransformer\StationStateStatusToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class SymfonyAssignStationStateToStationType extends AbstractType
{
    /**
     * @var StationStateStatusToStringTransformer
     */
    private $statusTransformer;

    /**
     * @param StationStateStatusToStringTransformer $statusTransformer
     */
    public function __construct(StationStateStatusToStringTransformer $statusTransformer)
    {
        $this->statusTransformer = $statusTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('externalStationId', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('availableBikeNumber', IntegerType::class, ['constraints' => new Assert\NotBlank()])
            ->add('availableSlotNumber', IntegerType::class, ['constraints' => new Assert\NotBlank()]);

        $builder->get('status')->addModelTransformer($this->statusTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => AssignStationStateToStationCommand::class]);
    }
}
