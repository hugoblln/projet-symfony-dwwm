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
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

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

        $today = new \DateTimeImmutable();
        $oneMonthLater = $today->modify('+1 month');


        $builder
            ->add('date', DateType::class, [
                'label' => 'choisissez une date :',
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTimeImmutable(),
                'years' => [date('Y')], //limite la selection a l'année en cours
                'months' => range($today->format('m'), $oneMonthLater->format('m')), // limite la selection au mois actuel et m+1
                'constraints' => [
                    new GreaterThanOrEqual([ // vérifie que la date n'est pas dans le passé
                        'value' => $today,
                        'message' => 'La date doit être aujourd\'hui ou dans le futur.'
                    ]),
                    new LessThanOrEqual([ // vérifie que la date n'est pas supèrieur a m+1
                        'value' => $oneMonthLater,
                        'message' => 'La date ne peut pas être à plus d\'un mois dans le futur.'
                    ])
                ]
            ])
            ->add('creneau', ChoiceType::class, [
                'choices' => $choices,
                'label' => 'choisissez le créneau qui vous convient :',
                'row_attr' => [
                    'class' => 'creneaux'
                ]
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
