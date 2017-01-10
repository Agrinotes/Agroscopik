<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FertilizerPriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fertilizer',EntityType::class, array(
                'class' => 'AppBundle:Fertilizer',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control select2'),
                'label' => 'Choisir un engrais ou amendement'
            ))
            ->add('pn', IntegerType::class, array(
                'required' => false,
                'label' => 'Province Nord',
                'attr' => array('class' => 'form-control', 'min' => 0),
            ))
            ->add('ps', IntegerType::class, array(
                'required' => false,
                'label' => 'Province Sud < 500kg',
                'attr' => array('class' => 'form-control', 'min' => 0),
            ))
            ->add('pn500', IntegerType::class, array(
                'required' => false,
                'label' => 'Province Nord > 500kg',
                'attr' => array('class' => 'form-control', 'min' => 0),
            ))
            ->add('pil', IntegerType::class, array(
                'required' => false,
                'label' => 'Province des îles',
                'attr' => array('class' => 'form-control', 'min' => 0),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FertilizerPrice'
        ));
    }
}
