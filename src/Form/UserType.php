<?php

namespace App\Form;

use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('FirstName', TextType::class, [
            'label' =>'prenom',
            'required' => false,
            'attr' => [
                'placeholder' => 'hugo'
            ]
          ])
          ->add('LastName', TextType::class,[
            'label' => 'nom',
            'required' => false,
            'attr' => [
                'placeholder' => 'bellin'
            ]
          ])
          ->add('email', EmailType::class, [
            'label' => 'Email',
            'required' => false,
            'attr' => [
                'placeholder' => 'exemple@gmail.com'
            ]
          ])
          ->add('password', RepeatedType::class,[
            'mapped' => false,
            'type' => PasswordType::class,
            'required' => false,
            'invalid_message' => 'les mots de passes ne correspondent pas',
            'first_options' => [
                'label' => 'Mot De Passe',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 4096
                    ]),
                    new Assert\Regex(
                        pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                    )
                ]
            ],
            'second_options' => [
                'label' => 'confirmation mot de passe'
            ],
            'help' => 'le mot de passe doit contenir au minimum 1 lettre majuscule, minuscule, 1 chiffre et un caractère spécial'

          ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}