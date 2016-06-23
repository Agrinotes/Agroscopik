<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('username')
            ->add('firstName', TextType::class, array(
                    'label' => 'Prénom',
                    'required' => false,
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array('class' => 'floating-label'),
                )
            )
            ->add('lastName', TextType::class, array(
                    'label' => 'Nom',
                    'required' => false,
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array('class' => 'floating-label'),
                )
            )
            ->remove('email')
            ->add('email', EmailType::class, array(
                    'label' => 'Email',
                    'required' => false,
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array('class' => 'floating-label'),
                )
            )
            ->remove('plainPassword')
            ->add('plainPassword', PasswordType::class, array(
                    'label' => 'Mot de passe',
                    'required' => false,
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array('class' => 'floating-label'),
                )
            );
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }


}