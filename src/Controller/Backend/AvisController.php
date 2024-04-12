<?php

namespace App\Controller\Backend;

use App\Entity\Avis;
use App\Entity\Terrains;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/avis','admin.avis')]
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

        return $this->render('Backend/Avis/index.html.twig',[
            'allAvis' => $allAvis
        ]);
    }

    #[Route('/{id}/delete','.delete',methods: ['POST'])]
    public function delete(Avis $avis, Request $request ) : Response
    {
        if(!$avis) {
            $this->addFlash('error','avis non trouvé');

          return  $this->redirectToRoute('admin.avis.index');
        }

        if($this->isCsrfTokenValid('delete' . $avis->getId(), $request->request->get('token'))) {
            $this->em->remove($avis);
            $this->em->flush();

            $this->addFlash('success','avis supprimé avec succès');

        } else {
            $this->addFlash('error','token csrf invalides');
        }

        return $this->redirectToRoute('admin.avis.index', ['slug' => $avis->getTerrain()->getSlug()]);;
    }
}