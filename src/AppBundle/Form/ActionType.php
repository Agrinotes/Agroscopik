<?php

namespace AppBundle\Form;

use AppBundle\Form\ActionFarmSpecialityMvtType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\EventType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ActionType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intervention', EntityType::class, array(
                'class' => 'AppBundle:Intervention',
                'choice_label' => 'name',
                'attr' => array('class'=>'form-control','data-plugin'=>'select2'),
                'group_by' => 'interventionCategory.name',
                'label'=>'Choisir une intervention'
            ))
            ->add('periods', CollectionType::class, array(
                'entry_type' => EventType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'=>'Définir une ou plusieurs périodes d\'intervention',
            ))
            ->add('farmSpecialityMvts', CollectionType::class, array(
                'entry_type' => ActionFarmSpecialityMvtType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'=>'Définir les produits utilisés',
            ))
            ->add('harvestProducts', CollectionType::class, array(
                'entry_type' => HarvestProductType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'=>'Définir les quantités récoltées',
            ))
            ->add('comment',TextareaType::class,array(
                'label'=>'Ajouter un commentaire',
                'attr' => array('class' => 'form-control'),
                'required'=>false,
            ))
        ;

        // grab the user, do a quick sanity check that one exists
        $farm = $this->tokenStorage->getToken()->getUser()->getFarm()->getId();
        if (!$farm) {
            throw new \LogicException(
                'You need to have a farm !'
            );
        }

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($farm) {
                $form = $event->getForm();

                $tractorsOptions = array(
                    'class' => 'AppBundle:Tractor',
                    'choice_label' => 'model.label',
                    'label'=>'Choisir les tracteurs utilisés',
                    'attr' => array('class'=>'form-control','data-plugin'=>'select2'),
                    'required' => false,
                    'multiple' => true,
                    'expanded' => false,
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllForCurrentFarm($farm);
                    },
                );

                $form->add('tractors', EntityType::class, $tractorsOptions);

                $implementsOptions = array(
                    'class' => 'AppBundle:Implement',
                    'choice_label' => 'name',
                    'attr' => array('class'=>'form-control','data-plugin'=>'select2'),
                    'label'=>'Choisir les outils utilisés',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllForCurrentFarm($farm);
                    },
                );

                $form->add('implements', EntityType::class, $implementsOptions);
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Action'
        ));
    }
}
