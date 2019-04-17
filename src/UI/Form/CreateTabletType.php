<?php

namespace App\UI\Form;

use App\Domain\Entity\Tablet;
use App\UI\Form\DataTransformer\ManufacturerTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CreateTabletType
 * @author ereshkidal
 */
class CreateTabletType extends AbstractType
{
    /**
     * @var ManufacturerTransformer
     */
    private $manufacturerTransformer;

    /**
     * CreateTabletType constructor.
     * @param ManufacturerTransformer $manufacturerTransformer
     */
    public function __construct(ManufacturerTransformer $manufacturerTransformer)
    {
        $this->manufacturerTransformer = $manufacturerTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', TextType::class)
            ->add('description', TextareaType::class)
            ->add('manufacturer', TextType::class)
            ->add('price', IntegerType::class)
            ->add('stock', IntegerType::class)
        ;

        $builder->get('manufacturer')->addModelTransformer($this->manufacturerTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tablet::class
        ]);
    }
}
