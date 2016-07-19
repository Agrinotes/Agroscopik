<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FarmSpecialityMvtType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:FarmSpecialityMvtCategory',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir le type d\'ajustement',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('amount',NumberType::class,array(
                'label'=>'Entrer la quantité correspondante',
                'attr' => array('class' => 'form-control','placeholder'=>'0.00'),

            ))
            ->add('unit',EntityType::class,array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir l\'unité',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('pricePerUnit',NumberType::class,array(
                'label'=>'Entrer le prix correspondant',
                'attr' => array('class' => 'form-control','placeholder'=>'0.00'),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FarmSpecialityMvt'
        ));
    }
}
