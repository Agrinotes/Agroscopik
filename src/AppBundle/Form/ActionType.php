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
            ))
            ->add('periods', CollectionType::class, array(
                'entry_type' => EventType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('implements', EntityType::class, array(
                'class' => 'AppBundle:Implement',
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'expanded' => false,
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

                $formOptions = array(
                    'class' => 'AppBundle:Tractor',
                    'choice_label' => 'name',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllForCurrentFarm($farm);
                    },
                );

                // create the field, this is similar the $builder->add()
                // field name, field type, data, options
                $form->add('tractors', EntityType::class, $formOptions);
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
