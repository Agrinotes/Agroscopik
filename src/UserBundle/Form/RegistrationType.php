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
            ->remove('email')
            ->add('email',EmailType::class,array(
                'label'=>'Mail'
            ))
            ->add('firstName', TextType::class,
            array(
                'label'=>'Prénom'
            ))
            ->add('lastName', TextType::class,
                array(
                    'label'=>'Nom'
                ))

            ->remove('plainPassword')
            ->add('plainPassword', PasswordType::class,
                array(
                    'label'=>'Mot de passe'
                ));
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