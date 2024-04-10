<?php

namespace App\Controller\Backend;

use App\Entity\Terrains;
use App\Repository\AvisRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/avis','admin.avis')]
class AvisController extends AbstractController
{
    public function __construct(
        private AvisRepository $avisRepo
    ){

    }


    #[Route('/{slug}','.index',methods:['GET'])]
    public function index(Terrains $terrain){

        $allAvis = $this->avisRepo->findAllByDate($terrain->getId());

        return $this->render('Backend/Avis/index.html.twig',[
            'allAvis' => $allAvis
        ]);
    }
}