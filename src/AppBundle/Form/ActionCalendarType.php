<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\EventType;


class ActionCalendarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cropCycle', EntityType::class, array(
                'class'=> 'AppBundle\Entity\CropCycle',
                'choice_label' => 'name',
                'attr' => array('class' => 'form-control select2'),
                'group_by' => 'plot.name',
                'label' => 'Choisir un cycle de culture en cours'
            ))

;
    }

    public function getParent()
    {
        return ActionType::class;
    }
}
