<?php

namespace App\Form;

// use App\Entity\Terrains;
// use App\Form\TerrainType;
// use App\Filter\TerrainFilter;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\NumberType;

// class TerrainFilterType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
//             ->add('query', TextType::class, [
//                 'label' => false,
//                 'attr' => [
//                     'placeholder' => 'rechercher un terrain'
//                 ],
//                 'required' => false
//             ])
//             ->add('min', NumberType::class, [
//                 'label' => false,
//                 'attr' => [
//                     'placeholder' => 'min'
//                 ],
//                 'required' => false
//             ])
//             ->add('max', NumberType::class, [
//                 'label' => false,
//                 'attr' => [
//                     'placeholder' => 'max'
//                 ],
//                 'required' => false
//             ])
//             ->add('ville', EntityType::class, [
//                 'label' => false,
//                 'required' => false,
//                 'class' => Terrains::class,
//                 'query_builder' => function (EntityRepository $er) {
//                     return $er->createQueryBuilder('t')
//                     ->andWhere('t.ville' = :ville)
//                 }
//                 ]
//             )
//         ;
//     }

//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             /* Définit la class ratachée au formulaire */
//             'data_class' => TerrainFilter::class,
//             /* définit la méthode du formulaire */
//             'method' => 'GET',
//             /* Désactive la protection csrf */
//             'csrf_protection' => false
//         ]);
//     }

//     public function getBlockPrefix(): string
//     {
//         return '';
//     }
// }

use App\Filter\TerrainFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// propriétés que l'on souhaite filtrer

class TerrainFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', TextType::class, [
                'required' => false,
                'label' => 'Recherche'
            ])
            ->add('min', IntegerType::class, [
                'required' => false,
                'label' => 'Prix Min'
            ])
            ->add('max', IntegerType::class, [
                'required' => false,
                'label' => 'Prix Max'
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'label' => 'Ville'
            ])
            ->add('typeTerrain', ChoiceType::class, [
                'choices' => [
                    'Intérieur' => 'indoor',
                    'Extérieur' => 'outdoor',
                ],
                'expanded' => true,  // Permet des boutons radio
                'multiple' => true,  // Permet de sélectionner plusieurs types
                'required' => false,
                'label' => 'Type de terrain'
            ])
            ->add('sort', ChoiceType::class, [
                'choices' => [
                    'Prix' => 'price',
                    'Popularité' => 'popularity',
                ],
                'required' => false,
                'label' => 'Trier par'
            ])
            ->add('order', ChoiceType::class, [
                'choices' => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                ],
                'required' => false,
                'label' => 'Ordre'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TerrainFilter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return ''; // Evite d'avoir un préfixe de formulaire, pour des URL propres
    }
}
