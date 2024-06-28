<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, [
                'label' => 'prenom:',
                'required' => false,
            ])
            ->add('LastName', TextType::class, [
                'label' => 'nom:',
                'required' => false

            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'required' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'vous devez accepter nos termes',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'required' => false,
                'invalid_message' => 'les mots de passes ne correspondent pas',
                'first_options' => [
                    'label' => 'Mot De Passe:',
                    'constraints' => [
                        new Assert\NotBlank(
                            [],
                            message: 'veuillez renseigner un mot de passe'
                        ),
                        new Assert\Length([
                            'max' => 4096
                        ]),
                        new Assert\Regex(
                            pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                            message: 'le mot de passe doit contenir au minimum 1 lettre majuscule, minuscule, 1 chiffre et un caractère spécial'
                        )
                    ]
                ],
                'second_options' => [
                    'label' => 'confirmation mot de passe:'
                ],
                'help' => 'le mot de passe doit contenir au minimum 1 lettre majuscule, minuscule, 1 chiffre et un caractère spécial'

            ]);

        if ($options['isAdmin']) {
            $builder->remove('password')
                ->add('roles', ChoiceType::class, [
                    'label' => 'roles:',
                    'placeholder' => 'selectionnez un role',
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Administrateur' => 'ROLE_ADMIN',
                        'Propriétaire' => 'ROLE_PROPRIETAIRE',
                    ],
                    'expanded' => true,
                    'multiple' => true
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'isAdmin' => false,
            'sanitize_html' => true
        ]);
    }
}
