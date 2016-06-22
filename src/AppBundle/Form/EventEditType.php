<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDatetime',DateTimeType::class, array(
                'date_widget' => 'single_text',
                'label'=>'Début d\'intervention',
                'time_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'html5'   => false,
                'data' => new \DateTime(),
                'required' => true,
            ))
            ->add('endDatetime', DateTimeType::class, array(
                'date_widget' => 'single_text',
                'label'=>'Fin d\'intervention',
                'time_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'html5'   => false,
                'data' => new \DateTime(),
                'required' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }
}
