<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
                'group_by' => 'interventionCategory.name'
            ))
            ->add('periods', CollectionType::class, array(
                'entry_type' => EventType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
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
                    'choice_label' => 'name',
                    'label'=>'Tracteurs',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllForCurrentFarm($farm);
                    },
                );

                $form->add('tractors', EntityType::class, $tractorsOptions);

                $implementsOptions = array(
                    'class' => 'AppBundle:Implement',
                    'choice_label' => 'name',
                    'label'=>'Outils',
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
