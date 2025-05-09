<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(
                        [],
                        message: 'veuillez saisir un nom'
                    ),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(
                        [],
                        message: 'veuillez saisir un email'
                    ),
                    new Assert\Email(
                        message: 'l\'email saisit n\'est pas valide'
                    )
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'numero de téléphone',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(
                        [],
                        message: 'veuillez saisir un numero de téléphone'
                    ),
                    new Assert\Regex(
                        pattern: '/^(0|(\+[0-9]{2}[. -]?))[1-9]([. -]?[0-9][0-9]){4}$/',
                        message: 'veuillez rentrer un numero de téléphone valide'
                    )
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'votre commentaire',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(
                        [],
                        message: 'veuillez saisir un message'
                    ),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
