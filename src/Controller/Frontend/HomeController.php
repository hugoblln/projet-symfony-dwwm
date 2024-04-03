<?php

namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('','app.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('/Frontend/accueil/index.html.twig');
    }
}