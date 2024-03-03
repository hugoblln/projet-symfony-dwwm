<?php

namespace App\Controller\Backend;

use App\Entity\Terrains;
use App\Form\TerrainType;
use App\Repository\TerrainsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/terrains', name: 'admin.terrains')]
class TerrainsController extends AbstractController
{

    public function __construct(
        private TerrainsRepository $terrainRepo,
        private EntityManagerInterface $em,
    ) 
    {    
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('backend/terrains/index.html.twig', [
            'terrains' => $this->terrainRepo->findAll()
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

            return $this->redirectToRoute('admin.terrains.index');
        }

        return $this->render('Backend/Terrains/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit','.edit', methods:['GET','POST'])]
    public function edit(Terrains $terrain, Request $request) : Response
    {

        if(!$terrain) {
            $this->addFlash('error','terrain non trouvé');

            return$this->redirectToRoute('admin.terrains.index');
        }

        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($terrain);
            $this->em->flush();

            $this->addFlash('success','terrain modifié avec succes');

            return $this->redirectToRoute('admin.terrains.index');
        }

        return $this->render('Backend/Terrains/edit.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(Terrains $terrain, Request $request): Response
    {
        if(!$terrain) {
            $this->addFlash('error','terrain non trouvé');

            return$this->redirectToRoute('admin.terrains.index');
        }

        if($this->isCsrfTokenValid('delete' . $terrain->getId(), $request->request->get('token'))) {
            $this->em->remove($terrain);
            $this->em->flush();

            $this->addFlash('success', 'terrain supprimé avec succès');

        }  else {
            $this->addFlash('error', 'token csrf invalides');
        }

        return $this->redirectToRoute('admin.terrains.index');
    }
}
