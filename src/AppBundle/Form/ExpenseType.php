<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'required'=>false,
                'attr'=>array('class'=>'form-control','placeholder'=>'Intitulé dépense'),
                'label' => '',
                'label_attr' => array('class'=>'hidden')
            ))
            ->add('amount',IntegerType::class,array(
                'required' => false,
                'attr'=>array('class'=>'form-control', 'placeholder' => '0'),
                'label' => '',
                'label_attr' => array('class'=>'hidden')

            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Expense'
        ));
    }
}
