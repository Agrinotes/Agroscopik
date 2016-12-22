<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropCycleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('crops', EntityType::class, array(
                'label' => 'Choisir votre culture',
                'class' => 'AppBundle:Crop',
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),

            ))
            ->add('varieties',TextType::class,array(
                'label' => 'Renseigner les variétés',
                'attr' => array('class' => 'form-control'),
                'required'=> false,
            ))
            ->add('area',TextType::class,array(
                'label' => 'Entrer la surface de culture (hectares)',
                'attr' => array('class' => 'form-control'),
                'required' =>'true'
            ))
            ->add('latLngs',TextType::class,array(
                'attr' => array('class' => 'hidden'),
                'label_attr' => array('class' => 'hidden'),
                'required' =>'false'
            ))
            ->add('status', ChoiceType::class, array(
                'multiple' => false,
                'expanded' => true,
                'choices' => array(
                    'En cours' => 'ActiveAction',
                    'Terminé' => 'CompletedAction',
                )));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CropCycle'
        ));
    }
}
