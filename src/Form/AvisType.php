<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\Users;
use App\Entity\Terrains;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('note', ChoiceType::class, [
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            'row_attr' => [
                'class' => 'formcarry-block',
            ],
            'attr'=> [
                'class' => null
            ],
        ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'formcarry-block',
                ],
                'attr'=> [
                    'class' => null
                ],
                'inherit_data' => false, // Désactiver l'héritage des données des champs parents
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
            
        ]);
    }
}
