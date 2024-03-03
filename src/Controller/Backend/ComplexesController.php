<?php

namespace App\Controller\Backend;

use App\Entity\Complexes;
use App\Form\ComplexesType;
use App\Repository\ComplexesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/complexes', name: 'admin.complexes')]
class ComplexesController extends AbstractController
{

    public function __construct(
        private ComplexesRepository $terrainRepo,
        private EntityManagerInterface $em,
    ) 
    {    
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        
        return $this->render('backend/complexes/index.html.twig', [
            'complexes' => $this->terrainRepo->findAll()
        ]);
    }

    #[Route('/create', '.create', methods: ['GET','POST'])]
    public function create(Request $request) : Response|RedirectedResponse
    {
        $complexe = new Complexes;

        $form = $this->createForm(ComplexesType::class, $complexe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($complexe);
            $this->em->flush();

            $this->addFlash('success', 'complexe créer avec succes');

            return $this->redirectToRoute('admin.complexes.index');
        }

        return $this->render('Backend/Complexes/create.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET','POST'])]
    public function edit(Complexes $complexe, Request $request) : Response|RedirectedResponse
    {
        if(!$complexe) {

            $this->addFlash('error','complexe non trouvé');

            return $this->redirectToRoute('admin.complexes.index');
        }


       $form = $this->createForm(ComplexesType::class, $complexe);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($complexe);
        $this->em->flush();

        $this->addFlash('success', 'ncomplexe modifier avec succès');

        return $this->redirectToRoute('admin.complexes.index');
       }

       return $this->render('Backend/Complexes/edit.html.twig',[
        'form' => $form
       ]);
        
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(Complexes $complexe, Request $request) : Response|RedirectedResponse
    {
        
        if(!$complexe) {

            $this->addFlash('error','complexe non trouvé');

            return $this->redirectToRoute('admin.complexes.index');
        }

        if($this->isCsrfTokenValid('delete' . $complexe->getId(), $request->request->get('token'))) {
            $this->em->remove($complexe);
            $this->em->flush();

            $this->addFlash('success', 'complexe supprimé avec succès');

        } else {
            $this->addFlash('error', 'Token csrf invalides');
        }

        return $this->redirectToRoute('admin.complexes.index');

    }
}
