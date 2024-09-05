<?php

namespace App\Form;


use App\Filter\TerrainFilter;
use App\Repository\TerrainsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



class TerrainFilterType extends AbstractType
{
    public function __construct(
        TerrainsRepository $terrainsRepo
    ) {
        $this->terrainsRepo = $terrainsRepo;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $types = $this->terrainsRepo->findTypesTerrains();
        $choices = [];

        foreach ($types as $type) {
            $choices[$type['typeTerrain']] = $type['typeTerrain'];
        }



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
                'choices' => $choices,
                'expanded' => true,  // Permet des boutons radio
                'multiple' => true,  // Permet de sélectionner plusieurs types
                'required' => false,
                'label' => 'Type de terrain'
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
