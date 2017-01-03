<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IrrigationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('volume',NumberType::class, array(
                'label'=>'Volume d\'eau',
                'attr' => array('class' => 'form-control volume','placeholder'=>'0'),
                'label_attr' => array('class'=>'volume'),
                'required'=>false,
            ))
            ->add('volumeUnit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control volume'),
                'label' => '',
                'label_attr' => array('class'=>'hidden'),
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.unitCategory', 'cat')
                        ->addSelect('cat')
                        ->where('cat.slug = :slug')
                        ->setParameter('slug','volume_area_density')
                        ->orWhere('cat.slug = :slug2')
                        ->setParameter('slug2','volume')
                        ;
                },
            ))
            ->add('duration',NumberType::class, array(
                'label'=>'Durée (minutes)',
                'attr' => array('class' => 'form-control durationFlow hidden','placeholder'=>'0'),
                'label_attr' => array('class'=>'durationFlow hidden'),
                'required'=>false,
            ))
            ->add('flow',NumberType::class, array(
                'label'=>'Débit total de la parcelle',
                'attr' => array('class' => 'form-control durationFlow hidden','placeholder'=>'0'),
                'label_attr' => array('class'=>'durationFlow hidden'),
                'required'=>false,
            ))
            ->add('flowUnit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control durationFlow hidden'),
                'label' => '',
                'label_attr' => array('class'=>' hidden'),
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.unitCategory', 'cat')
                        ->addSelect('cat')
                        ->where('cat.slug = :slug')
                        ->setParameter('slug','volume_flow')
                        ;
                },
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Irrigation'
        ));
    }
}
