<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password', RepeatedType::class, [
            'type' => PasswordType::class,
            // 'mapped' => false,
            'invalid_message' => 'Le nouveau mot de passe et sa confirmation doivent être identique',
            'label' => 'Mon nouveau mot de passe',
            'required' => true,
            'first_options' => ['label' => 'Mon nouveau mot de passe', 
                                'attr' => ['placeholder' => 'Veuillez entre un nouveau mot de passe'
                                ]],
            'second_options' => ['label' => 'Confirmation du nouveau mot de passe', 
                                'attr' => ['placeholder' => 'Veuillez confirmer votre nouveau mot de passe'
                                ]],
        ])

        ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour mon mot de passe",
            'attr' => [
                'class' => 'd-grid gap-2 col-6 mt-4 mx-auto btn btn-success'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
