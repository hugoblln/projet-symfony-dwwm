<?php

namespace App\Controller\Backend\Proprietaire;


use App\Entity\Terrains;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/proprietaire/reservations', name : 'proprietaire.reservations')]
class ReservationController extends AbstractController
{

    private $reservationRepo;
    
    public function __construct(ReservationsRepository $reservationRepo) 
    {
         $this->reservationRepo = $reservationRepo;
     }
    
    #[Route('/{slug}', name: '.index', methods: ['GET'])]
    public function index(Terrains $terrain): Response
    {
        $reservations = $this->reservationRepo->findReservationsByTerrain($terrain->getId());



        return $this->render('backend/proprietaire/reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
