<?php

namespace App\Controller\Frontend;

use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class reservationsController extends AbstractController
{

    public function __construct(
        private ReservationsRepository $resRepo
    ) {}

    #[Route('/reservations', name: 'app.reservations')]
    public function index(): Response
    {

        $reservations = $this->resRepo->findUserReservations($this->getUser()->getId());


        setlocale(LC_TIME, 'fr_FR.UTF-8');

        return $this->render('Frontend/Reservations/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
