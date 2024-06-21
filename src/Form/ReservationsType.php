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
        $this->creneauxRepo = $creneauxRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $creneaux = $this->creneauxRepo->findCreneauxComplexe($options['complexe_id']);
        $choices = [];
        
        foreach ($creneaux as $creneau) {
            $choices[$creneau['creneau']] = $creneau['creneau'];
        }

        
        $builder
            ->add('date', DateType::class, [
                 'widget' => 'choice',
                 'input'  => 'datetime_immutable',
                 'format' => 'yyyy-MM-dd',
            ])
            ->add('creneau',ChoiceType::class, [
                'choices' => $choices,
                'label' => 'Créneau',
            ]);
      
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            'complexe_id' => null, 
        ]);
    }
}
