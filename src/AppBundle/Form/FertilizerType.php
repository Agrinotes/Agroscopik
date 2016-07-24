<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FertilizerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('formula')
            ->add('n')
            ->add('p2O5')
            ->add('k2O')
            ->add('caO')
            ->add('mgO')
            ->add('fe')
            ->add('sO3')
            ->add('zn')
            ->add('b')
            ->add('mn')
            ->add('cu')
            ->add('comment')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Fertilizer'
        ));
    }
}
