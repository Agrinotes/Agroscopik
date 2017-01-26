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

class FarmSpecialityMvtUpdateStockType extends AbstractType
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
                'attr' => array('class' => 'form-control select2'),
                'label' => 'Choisir le type d\'ajustement',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('cat')
                        ->where('cat.slug = :slug')
                        ->setParameter('slug','updateStockAction')
                        ->orWhere('cat.slug = :slug2')
                        ->setParameter('slug2','buyAction')
                        ;
                },
            ))
            ->add('amount',NumberType::class,array(
                'label'=>'Entrer la quantité correspondante',
                'attr' => array('class' => 'form-control'),

            ))

            ->add('price',NumberType::class, array(
                'label'=>'Entrer le prix d\'achat',
                'attr' => array('class' => 'form-control'),
                'required'=>false,
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $mvt = $event->getData();
            $form = $event->getForm();

            $cat = $mvt->getSpeciality()->getSpeciality()->getUnitCategory()->getSlug();



            if($cat == "mass"){
            $form->add('unit',EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control select2'),
                'label' => 'Choisir l\'unité',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.slug', 'slug')
                        ->setParameter('slug','kilogram')
                        ;
                },
            ));
            }elseif($cat == "volume"){
                $form->add('unit',EntityType::class, array(
                    'class' => 'AppBundle:Unit',
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'label' => 'Choisir l\'unité',
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.slug = :slug')
                            ->setParameter('slug','liter')
                            ;
                    },
                ));
            }else{
                $form->add('unit',EntityType::class, array(
                    'class' => 'AppBundle:Unit',
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'label' => 'Choisir l\'unité',
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.slug = :slug')
                            ->setParameter('slug','liter')
                            ->orWhere('u.slug = :slug2')
                            ->setParameter('slug2','kilogram')
                            ->orWhere('u.slug = :slug3')
                            ->setParameter('slug3','unity')
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
            'data_class' => 'AppBundle\Entity\FarmSpecialityMvt'
        ));
    }
}
