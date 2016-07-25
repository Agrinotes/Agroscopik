<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FarmFertilizerMvtType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:FarmSpecialityMvtCategory',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir le type d\'ajustement',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('amount',NumberType::class,array(
                'label'=>'Entrer la quantité correspondante',
                'attr' => array('class' => 'form-control','placeholder'=>'0.00'),

            ))
            ->add('price',NumberType::class, array(
                'label'=>'Entrer le prix d\'achat',
                'attr' => array('class' => 'form-control','placeholder'=>'0.00'),
                'required'=>false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $mvt = $event->getData();
            $form = $event->getForm();

            $cat = $mvt->getFertilizer()->getFertilizer()->getFormula();



            if($cat == "granule" || $cat == "granulé" || $cat == "poudre"){
                $form->add('unit',EntityType::class, array(
                    'class' => 'AppBundle:Unit',
                    'choice_label' => 'name',
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
                            ;
                    },
                ));
            }elseif($cat == "liquide"){
                $form->add('unit',EntityType::class, array(
                    'class' => 'AppBundle:Unit',
                    'choice_label' => 'name',
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
                            ->setParameter('slug','volume')
                            ;
                    },
                ));
            }else{
                $form->add('unit',EntityType::class, array(
                    'class' => 'AppBundle:Unit',
                    'choice_label' => 'name',
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
        });

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
