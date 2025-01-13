<?php

namespace App\Controller\Backend\Proprietaire;

use Exception;
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
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('Backend/Proprietaire/Complexes/index.html.twig', [
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
            $complexe->setEnable(false);

            $this->em->getConnection()->beginTransaction();

            try{
                $this->em->persist($complexe);
                $this->em->flush();

                $this->em->getConnection()->commit();

                $this->addFlash('success', 'complexe créer avec succes');
            } catch (Exception $e) {
                $this->em->getConnection()->rollBack();
                $this->addFlash('error', 'Erreur lors de la création du complexe');
            }

            return $this->redirectToRoute('proprietaire.complexes.index');
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

            return $this->redirectToRoute('proprietaire.complexes.index');
        }


        $form = $this->createForm(ComplexesType::class, $complexe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $complexe->setEnable(false);

            $this->em->getConnection()->beginTransaction();

            try {
                $this->em->persist($complexe);
                $this->em->flush();

                $this->em->getConnection()->commit();

            $this->addFlash('success', 'complexe modifier avec succès');

            } catch (\Exception $e) {
                $this->em->getConnection()->rollBack();
                $this->addFlash('error', 'Erreur lors de la modification du complexe');
            }
           

            return $this->redirectToRoute('proprietaire.complexes.index');
        }

        return $this->render('Backend/Proprietaire/Complexes/edit.html.twig', [
            'form' => $form
        ]);
    }
}
