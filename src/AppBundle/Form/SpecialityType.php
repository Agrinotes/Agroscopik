<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amm')
            ->add('name')
            ->add('fds',UrlType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "URL Fiche de données de sécurité",
            ))
            ->add('ft',UrlType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "URL Fiche technique",
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Speciality'
        ));
    }
}
