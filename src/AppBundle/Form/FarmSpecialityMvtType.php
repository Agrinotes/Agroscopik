<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('datetime', DateTimeType::class,array(
                'attr'=>array('class'=>'date')
            ))
            ->add('speciality', EntityType::class, array(
                'class' => 'AppBundle:FarmSpeciality',
                'choice_label' => 'speciality.name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir le produit sur lequel se fait la transaction',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:FarmSpecialityMvtCategory',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir la catégorie',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('amount',IntegerType::class,array(
                'label'=>'Entrer la quantité correspondante',
            ))
            ->add('unit')
            ->add('pricePerUnit');
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
