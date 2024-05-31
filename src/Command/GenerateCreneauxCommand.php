<?php

namespace App\Command;

use App\Entity\Creneaux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// nom de la commande a tape dans le terminal
#[AsCommand(name: 'app:generate-creneaux')]
class GenerateCreneauxCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }


    protected function configure()
    {

        // ajoute une description qui sera afficher lors de l'utilisation de la commande dans le terminal
        $this->setDescription('generer des créneaux pour une journée entière');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // personnalise les sorties de commandes 
        $io = new SymfonyStyle($input, $output);


        // on supprime les creneaux existants s'il y en a pour éviter les doublons
        $this->em->createQuery('DELETE FROM App\Entity\Creneaux c')->execute();

        // on definit l'intervalle de temps pour les creneaux
        $heureDebut = new \Datetime('00:00:00');
        $heureFin = new \Datetime('23:59:59');

        // on crée le créneau horaire
        $currentTime = clone $heureDebut;
        while ($currentTime < $heureFin) {
            $debut = clone $currentTime;
            $fin = clone $currentTime;
            // ajout d'une heure a $fin
            $fin->add(new \DateInterval('PT1H'));

            $creneau = new Creneaux();
            $creneau->setDebut($debut);
            $creneau->setFin($fin);

            // on met en file d'attente 
            $this->em->persist($creneau);

            // on initialise currentTime à +1heure pour le prochain creneau
            $currentTime = $fin;
        }

        // on envoie tout les creneaux en base de données
        $this->em->flush();

        // message de succès
        $io->success('Créneaux généré avec succès');

        // retourne un code de succes a la console 
        return Command::SUCCESS;
    }
}
