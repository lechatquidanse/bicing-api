<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\Form\Symfony\Type;

use App\Application\UseCase\Command\CreateStationCommand;
use App\Infrastructure\Factory\Form\DataTransformer\StationDetailTypeToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SymfonyCreateStationType extends AbstractType
{
    /**
     * @var StationDetailTypeToStringTransformer
     */
    private $typeTransformer;

    /**
     * @param StationDetailTypeToStringTransformer $typeTransformer
     */
    public function __construct(StationDetailTypeToStringTransformer $typeTransformer)
    {
        $this->typeTransformer = $typeTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('type', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('externalStationId', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('nearByExternalStationIds', CollectionType::class, [
                'constraints' => new Assert\NotBlank(),
                'allow_add'   => true,
            ])
            ->add('address', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('addressNumber', TextType::class)
            ->add('districtCode', IntegerType::class, ['constraints' => new Assert\NotBlank()])
            ->add('zipCode', TextType::class, ['constraints' => new Assert\NotBlank()])
            ->add('latitude', NumberType::class, ['constraints' => new Assert\NotBlank()])
            ->add('longitude', NumberType::class, ['constraints' => new Assert\NotBlank()]);

        $builder->get('type')->addModelTransformer($this->typeTransformer);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => CreateStationCommand::class]);
    }
}
