<?php

namespace App\Controller\Backend\Proprietaire;

use App\Entity\Complexes;
use App\Form\ComplexesType;
use App\Repository\ComplexesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/proprietaire/complexes', name: 'proprietaire.complexes')]
class ComplexesController extends AbstractController
{

    public function __construct(
        private ComplexesRepository $complexeRepo,
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('Backend/Proprietaire/complexes/index.html.twig', [
            'complexes' => $this->complexeRepo->FindAllProprietaireComplexe($this->getUser()->getId())
        ]);
    }

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectedResponse
    {
        $complexe = new Complexes;

        $form = $this->createForm(ComplexesType::class, $complexe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $complexe->setProprietaire($this->getUser());

            $this->em->persist($complexe);
            $this->em->flush();

            $this->addFlash('success', 'complexe créer avec succes');

            return $this->redirectToRoute('admin.complexes.index');
        }

        return $this->render('Backend/Proprietaire/Complexes/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(Complexes $complexe, Request $request): Response|RedirectedResponse
    {
        if (!$complexe) {

            $this->addFlash('error', 'complexe non trouvé');

            return $this->redirectToRoute('admin.complexes.index');
        }


        $form = $this->createForm(ComplexesType::class, $complexe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($complexe);
            $this->em->flush();

            $this->addFlash('success', 'complexe modifier avec succès');

            return $this->redirectToRoute('admin.complexes.index');
        }

        return $this->render('Backend/Proprietaire/Complexes/edit.html.twig', [
            'form' => $form
        ]);
    }
}
