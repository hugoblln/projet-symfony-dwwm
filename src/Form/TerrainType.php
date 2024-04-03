<?php

namespace App\Form;

use App\Entity\Terrains;
use App\Entity\Complexes;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
             ->add('images', CollectionType::class,[
            'label' => false,
            'required' => false,
            'entry_type' => TerrainsImageType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference' => false
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
            ])
            ->add('complexe', EntityType::class, [
                'class' => Complexes::class,
                'placeholder' => 'sélectionner un complexe',
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('c')
                    ->andWhere('c.enable = :enable')
                    ->setParameter('enable', true)
                    ->orderBy('c.nom','ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Terrains::class,
            'sanitize_html' => true
        ]);
    }
}