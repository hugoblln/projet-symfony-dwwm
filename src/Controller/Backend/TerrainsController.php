<?php

namespace App\Controller\Backend;

use App\Repository\TerrainsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/terrains', name: 'admin.terrains')]
class TerrainsController extends AbstractController
{

    public function __construct(
        private TerrainsRepository $userRepo,
        private EntityManagerInterface $em
    ) 
    {    
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('backend/terrains/index.html.twig', [
            'terrains' => $this->userRepo->findAll()
        ]);
    }
}
