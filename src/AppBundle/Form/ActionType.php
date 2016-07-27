<?php

namespace AppBundle\Form;

use AppBundle\Form\ActionFarmSpecialityMvtType;
use AppBundle\Form\ActionFarmFertilizerMvtType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'group_by' => 'interventionCategory.name',
                'label' => 'Choisir une intervention'
            ))
            ->add('periods', CollectionType::class, array(
                'entry_type' => EventType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir une ou plusieurs périodes d\'intervention',
            ))
            ->add('nbWorkers', IntegerType::class, array(
                'required' => false,
                'label' => 'Définir le nombre de personnes pour cette intervention',
                'attr' => array('class' => 'form-control', 'min' => 0, 'placeholder' => '1'),
            ))
            ->add('farmSpecialityMvts', CollectionType::class, array(
                'entry_type' => ActionFarmSpecialityMvtType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir les produits utilisés',
            ))
            ->add('farmFertilizerMvts', CollectionType::class, array(
                'entry_type' => ActionFarmFertilizerMvtType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir les engrais et amendements utilisés',
            ))
            ->add('harvestProducts', CollectionType::class, array(
                'entry_type' => HarvestProductType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir les quantités récoltées',
            ))
            ->add('expenses', CollectionType::class, array(
                'entry_type' => ExpenseType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Définir les dépenses associées',
            ))
            ->add('aim', TextType::class, array(
                'label' => 'Cible(s) du traitement',
                'attr' => array('class' => 'form-control'),
                'required' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Ajouter un commentaire',
                'attr' => array('class' => 'form-control'),
                'required' => false,
            ))
            ->add('auxiliary', EntityType::class, array(
                'class' => 'AppBundle:Insect',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                'label' => 'Choisir l\'auxiliaire',
                'required' => false,
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('density', IntegerType::class, array(
                'label' => 'Définir la densité de semis/plantation',
                'attr' => array('class' => 'form-control', 'min' => 0, 'placeholder' => '0'),
                'required' => false,
            ))
            ->add('densityUnit', EntityType::class, array(
                'class' => 'AppBundle:Unit',
                'choice_label' => 'symbol',
                'attr' => array('class' => 'form-control'),
                'label' => 'Choisir l\'unité',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.slug = :slug')
                        ->setParameter('slug', 'unity')
                        ->orWhere('u.slug = :slug2')
                        ->setParameter('slug2', 'unity_per_hectare')
                        ->orWhere('u.slug = :slug3')
                        ->setParameter('slug3', 'unity_per_square_meter');
                },

            ));

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
                    'label' => 'Choisir les tracteurs utilisés',
                    'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
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
                    'attr' => array('class' => 'form-control', 'data-plugin' => 'select2'),
                    'label' => 'Choisir les outils utilisés',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => false,
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllForCurrentFarm($farm);
                    },
                );

                $form->add('implements', EntityType::class, $implementsOptions);
            }
        );

        $specs = $this->tokenStorage->getToken()->getUser()->getFarm()->getFarmSpecialities();

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($specs) {
                $form = $event->getForm();
                if (!count($specs) > 0) {
                    $form->remove('farmSpecialityMvts');
                    $form->remove('aim');

                }
            }
        );

        $fertis = $this->tokenStorage->getToken()->getUser()->getFarm()->getFarmFertilizers();

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($fertis) {
                $form = $event->getForm();
                if (!count($fertis) > 0) {
                    $form->remove('farmFertilizerMvts');
                }
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