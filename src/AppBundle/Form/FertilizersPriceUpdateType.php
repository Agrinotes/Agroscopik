<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FertilizersPriceUpdateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'label'=>'Date de mise à jour',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5'   => false,
                'data' => new \DateTime('now',new \DateTimeZone('Pacific/Noumea')),
                'required' => true,
            ))
            ->add('prices', CollectionType::class, array(
                'entry_type' => FertilizerPriceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir une ou plusieurs mises à jours des prix ',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FertilizersPriceUpdate'
        ));
    }
}
