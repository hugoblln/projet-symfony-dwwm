<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Creneaux;
use App\Entity\Terrains;
use App\Entity\Reservations;
use App\Repository\CreneauxRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationsType extends AbstractType
{

    public function __construct(
        CreneauxRepository $creneauxRepo
    ) {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
            ->add('date', DateType::class, [
                 'widget' => 'choice',
                 'input'  => 'datetime_immutable',
                 'format' => 'yyyy-MM-dd',
            ]);
      
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
        $resolver->setRequired('creneaux');
    }
}
