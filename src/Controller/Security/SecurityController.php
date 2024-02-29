<?php

namespace App\Controller\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/login','app.frontend.login', methods: ['GET','POST'])]
    public function login() : Response
    {
       

        return$this->render('/Security/login.html.twig',[
            
        ]);
    }
}