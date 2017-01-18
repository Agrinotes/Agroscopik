<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HarvestProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty',NumberType::class,array(
                'label' => 'Quantité récoltée',
                'attr' => array('class' => 'form-control'),
                'required' => false,

            ))
            ->add('unit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir l\'unité de récolte',
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
                        ->setParameter('slug2','mass_area_density')
                        ;
                },
                ))
            ->add('price',NumberType::class,array(
                'label' => 'Prix de vente moyen',
                'attr' => array('class' => 'form-control'),
                'required' => false,

            ))
            ->add('priceUnit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Unité du prix de vente',
                'required' => false,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.unitCategory', 'cat')
                        ->addSelect('cat')
                        ->where('cat.slug = :slug')
                        ->setParameter('slug','mass')
                        ;
                },
            ))
            ->add('comment',TextType::class,array(
                'label'=>'Ajouter un commentaire',
                'attr' => array('class' => 'form-control'),
                'required' => false,
            ))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\HarvestProduct'
        ));
    }
}
