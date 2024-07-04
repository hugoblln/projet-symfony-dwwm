<?php

namespace App\Controller\Backend\Proprietaire;

use App\Entity\Avis;
use App\Entity\Terrains;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('proprietaire/avis','admin.avis')]
class AvisController extends AbstractController
{
    public function __construct(
        private AvisRepository $avisRepo,
        private EntityManagerInterface $em
    ){
    }


    #[Route('/{slug}','.index',methods:['GET'])]
    public function index(Terrains $terrain) : Response {

        $allAvis = $this->avisRepo->findAllByDate($terrain->getId());

        return $this->render('Backend/Proprietaire/Avis/index.html.twig',[
            'allAvis' => $allAvis,
            'terrain' => $terrain,
            'complexe' => $terrain->getComplexe()
        ]);
    }

}