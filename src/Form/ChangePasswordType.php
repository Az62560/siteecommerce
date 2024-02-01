<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lastname', TextType::class, [
                'disabled' =>true,
                'label' => 'Mon nom',
                ])

            ->add('firstname', TextType::class, [
                'disabled' =>true,
                'label' => 'Mon prénom',
            ])

            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse Email'
            ])

            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel',
                ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
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
                'label' => "Modifier le mot de passe",
                'attr' => [
                    'class' => 'btn col-3 btn-success'
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
