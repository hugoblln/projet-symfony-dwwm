<?php

namespace App\Form;

use App\Entity\Complexes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ComplexesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => 'nom du complexe'
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => 'Adresse'
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description'
            ])
            ->add('HeureOuverture', TimeType::class, [
                'required' => false,
                'label' => 'heure d\'ouverture'
            ])
            ->add('HeureFermeture', TimeType::class, [
                'required' => false,
                'label' => 'heure de fermeture'
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'numéro de téléphone'
            ])
            ->add('enable', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif'
            ])
            ->add('ville', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Complexes::class,
            'sanitize_html' => true
        ]);
    }
}
