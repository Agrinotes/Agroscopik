<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionFarmFertilizerMvtType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:FarmFertilizerMvtCategory',
                'choice_label' => 'name',
                'label_attr' => array('class' => 'hidden'),
                'attr' => array('class' => 'hidden'),
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function (EntityRepository $er) {
                    return $er->createQueryBuilder("c")
                        ->where("c.slug = 'useAction'");
                },
            ))
            ->add('fertilizer', EntityType::class,array(
                'class' => 'AppBundle:FarmFertilizer',
                'choice_label' => 'fertilizer.name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir le nom de l\'engrais ou amendement',
                'label_attr' => array('class'=>''),
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('amount',NumberType::class,array(
                'label'=>'Entrer la quantité correspondante',
                'attr' => array('class' => 'form-control','placeholder'=>'0.00'),
                'required'=>false,

            ))
            ->add('unit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir l\'unité',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.unitCategory', 'cat')
                        ->addSelect('cat')
                        ->where('cat.slug = :slug')
                        ->setParameter('slug','mass')
                        ->orWhere('cat.slug = :slug2')
                        ->setParameter('slug2','volume')
                        ;
                },
            ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FarmFertilizerMvt'
        ));
    }
}