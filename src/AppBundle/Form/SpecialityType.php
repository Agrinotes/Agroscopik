<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amm',NumberType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Numéro d'AMM (Autorisation de Mise sur le Marché)",
            ))
            ->add('name',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>true,
                'label' => "Nom commercial",
            ))
            ->add('alternativeName',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Noms secondaires",
            ))
            ->add('unitCategory',EntityType::class,array(
                'class' => 'AppBundle:UnitCategory',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control'),
                'label' => "Choix de la catégorie des unités de mesure",
                'label_attr' => array('class'=>''),
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.slug = :slug')
                        ->setParameter('slug','mass')
                        ->orWhere('u.slug = :slug2')
                        ->setParameter('slug2','volume')
                        ->orWhere('u.slug = :slug3')
                        ->setParameter('slug3','none')
                        ;
                },
            ))
            ->add('composition',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Résumé de la composition",
            ))
            ->add('fds',UrlType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "URL Fiche de données de sécurité",
            ))
            ->add('ft',UrlType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "URL Fiche technique",
            ))
            ->add('owner',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>true,
                'label' => "Détenteur du nom commercial",
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Speciality'
        ));
    }
}
