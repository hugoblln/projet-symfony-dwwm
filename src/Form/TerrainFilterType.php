<?php

namespace App\Form;

use App\Entity\Terrains;
use App\Form\TerrainType;
use App\Filter\TerrainFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TerrainFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'rechercher un terrain'
                ],
                'required' => false
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'min'
                ],
                'required' => false 
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'max'
                ],
                'required' => false 
            ])
            // ->add('typeTerrain', EntityType::class, [
            //     'class' => Terrains::class,
            //     'choice_label' => 'typeTerrain'
            // ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TerrainFilter::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
} 
