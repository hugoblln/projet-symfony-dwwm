<?php

namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    #[Route('/admin/users', 'app.admin.users', methods: ['GET'])]
    public function index(): Response
    {
        
    }
}