<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
            ->add('name',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>true,
                'label' => "Entrer le nom de l'engrais ou amendement",
            ))
            ->add('formula',ChoiceType::class, array(
                'choices' => array(
                    'Solide' => 'granulé',
                    'Liquide' => 'liquide',
                ),
                'attr' => array('class'=>'form-control'),
                'label' => "Formulation",


            ))
            ->add('organic', CheckboxType::class, array(
                'label'    => 'Cocher si autorisé en bio',
                'required' => false
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

            ->add('n',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "N",
            ))
            ->add('p2O5',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "P2O5",
            ))
            ->add('k2O',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "K2O",
            ))
            ->add('caO',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "CaO",
            ))
            ->add('mgO',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "MgO",
            ))
            ->add('fe',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Fe",
            ))
            ->add('sO3',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "SO3",
            ))
            ->add('zn',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Zn",
            ))
            ->add('b',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "B",
            ))
            ->add('mn',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Mn",
            ))
            ->add('cu',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Cu",
            ))
            ->add('ismo',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "ISMO",
            ))
            ->add('cn',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "C/N",
            ))
            ->add('comment',TextType::class,array(
                'attr' => array('class'=>'form-control'),
                'required'=>false,
                'label' => "Commentaire",
            ))
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
