<?php

namespace App\UI\Form;

use App\Domain\Entity\Phone;
use App\UI\Form\DataTransformer\ManufacturerTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatePhoneType extends AbstractType
{
    /**
     * @var ManufacturerTransformer
     */
    private $transformer;

    public function __construct(ManufacturerTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model')
            ->add('description', TextareaType::class)
            ->add('manufacturer', TextType::class)
            ->add('price')
            ->add('stock')
        ;

        $builder->get('manufacturer')->addModelTransformer($this->transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Phone::class
        ]);
    }
}
