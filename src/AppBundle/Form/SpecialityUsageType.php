<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialityUsageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usageId')
            ->add('name')
            ->add('minCropStage')
            ->add('maxCropStage')
            ->add('status')
            ->add('dose')
            ->add('doseUnit')
            ->add('doseUnit2')
            ->add('dAR')
            ->add('maxActions')
            ->add('conditions')
            ->add('zNTwater')
            ->add('zNTarthropodes')
            ->add('zNTplants')
            ->add('speciality')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SpecialityUsage'
        ));
    }
}
