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


class ActionCalendarType extends AbstractType
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

                $cropCycleOptions = array(
                    'class'=> 'AppBundle\Entity\CropCycle',
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'group_by' => 'plot.name',
                    'label' => 'Choisir un cycle de culture en cours',
                    'query_builder' => function (EntityRepository $er) use ($farm) {
                        return $er->qbFindAllByFarm($farm);
                    },
                );

                $form->add('cropCycle', EntityType::class, $cropCycleOptions);

            }
        );
            }



    public function getParent()
    {
        return ActionType::class;
    }
}
