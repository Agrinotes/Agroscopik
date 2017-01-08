<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TractorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model', EntityType::class, array(
                'class' => 'AppBundle\Entity\TractorModel',
                'choice_label' => 'labelWithPower',
                'attr' => array('class' => 'form-control select2'),
                'group_by' => 'brand',
                'label' => 'Modèle'
            ))
            ->add('startDatetime', DateTimeType::class, array(
                'label' => 'Date d\'achat',
                'widget' => 'single_text',
                'format' => 'MM/yyyy',
                'attr' => array('class'=>'date form-control'),
                'html5' => false,
                'data' => new \DateTime('now', new \DateTimeZone('Pacific/Noumea')),
                'required' => false,
            ))
            ->add('price', IntegerType::class, array(
                'label' => 'Prix d\'achat',
                'attr' => array('class'=>'form-control'),
                'label_attr' => array('class'=>'control-label'),
                'required' => false
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tractor'
        ));
    }
}
