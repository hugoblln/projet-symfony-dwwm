<?php

namespace App\Controller\Backend\Proprietaire;

use App\Entity\Terrains;
use App\Entity\Complexes;
use App\Form\TerrainType;
use App\Repository\TerrainsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/proprietaire/terrains', name: 'proprietaire.terrains')]
class TerrainsController extends AbstractController
{

    public function __construct(
        private TerrainsRepository $terrainRepo,
        private EntityManagerInterface $em,
    ) 
    {    
    }

    #[Route('/{nom}', name: '.index', methods: ['GET'])]
    public function index(Complexes $complexe): Response
    {
        return $this->render('backend/Proprietaire/terrains/index.html.twig', [
            'terrains' => $this->terrainRepo->findByComplexe($complexe->getId()),
            'complexe' => $complexe
        ]);
    }

    #[Route('/create', '.create', methods: ['GET','POST'])]
    public function create(Request $request): Response
    {

        $terrain = new Terrains;

        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($terrain);
            $this->em->flush();

            $this->addFlash('success', 'nouveau terrain créer avec succès');

            return $this->redirectToRoute('proprietaire.terrains.index', ['nom' => $terrain->getComplexe()->getNom()]);
        }

        return $this->render('Backend/Proprietaire/Terrains/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/{slug}/edit','.edit', methods:['GET','POST'])]
    public function edit(Terrains $terrain, Request $request) : Response
    {

        if(!$terrain) {
            $this->addFlash('error','terrain non trouvé');

            return$this->redirectToRoute('proprietaire.terrains.index');
        }

        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($terrain);
            $this->em->flush();

            $this->addFlash('success','terrain modifié avec succes');

            return $this->redirectToRoute('proprietaire.terrains.index', ['nom' => $terrain->getComplexe()->getNom() ]);
        }

        return $this->render('Backend/Proprietaire/Terrains/edit.html.twig',[
            'form' => $form
        ]);
    }

   
}
