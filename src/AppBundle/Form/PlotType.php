<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlotType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'label' => "Entrer le nom de la parcelle",
                'required' => true,
                'label_attr' => array('class' => 'control-label')
            ))
            ->add('hydroponics', CheckboxType::class, array(
                'label'    => 'Cocher si c\'est une culture hors-sol',
                'required' => false
            ))
            ->add('area',TextType::class,array(
                'attr' => array('class' => 'form-control hidden'),
                'label' => "Entrer la surface de la parcelle",
                'label_attr' => array('class' => 'control-label hidden'),
            ))
            ->add('latLngs',TextType::class,array(
                'attr' => array('class' => 'form-control hidden'),
                 'label' => "Latitude et Longitudes des points",
                 'required' => false,
                'label_attr' => array('class' => 'control-label hidden'),
            ))            ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Plot'
        ));
    }
}
