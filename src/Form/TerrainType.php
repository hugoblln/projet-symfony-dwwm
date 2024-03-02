<?php

namespace App\Form;

use App\Entity\Terrains;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'nom du terrain',
                'required' => false,
                'attr' => [
                    'placeholder' => 'terrain numero 1'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description du terrain',
                'required' => false,
                'attr' => [
                    'placeholder' => 'description du terrain numero 1'
                ]
            ])
            ->add('typeTerrain', TextType::class, [
                'label' => 'type de terrain',
                'required' => false,
                'attr' => [
                    'placeholder' => '5 contre 5'
                ]
            ])
            ->add('taille', IntegerType::class, [
                'label' => 'taille du terrain',
                'required' => false,
                'attr' => [
                    'placeholder' => '50'
                ]
            ])
            ->add('enable', CheckboxType::class,[
                'label' => 'actif',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Terrains::class
        ]);
    }
}