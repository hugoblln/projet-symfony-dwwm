<?php

namespace App\Controller\Backend\Admin;

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
        private ComplexesRepository $complexeRepo,
        private EntityManagerInterface $em,
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('backend/Admin/complexes/index.html.twig', [
            'complexes' => $this->complexeRepo->findAllOrderByDate()
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(Complexes $complexe, Request $request): Response|RedirectedResponse
    {
        if (!$complexe) {

            $this->addFlash('error', 'complexe non trouvé');

            return $this->redirectToRoute('admin.complexes.index');
        }


        $form = $this->createForm(ComplexesType::class, $complexe, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

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
           

            return $this->redirectToRoute('admin.complexes.index');
        }

        return $this->render('Backend/Admin/Complexes/edit.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(Complexes $complexe, Request $request): Response|RedirectedResponse
    {

        if (!$complexe) {

            $this->addFlash('error', 'complexe non trouvé');

            return $this->redirectToRoute('admin.complexes.index');
        }

        if ($this->isCsrfTokenValid('delete' . $complexe->getId(), $request->request->get('token'))) {

            $this->em->getConnection()->beginTransaction();

            try {
                 $this->em->remove($complexe);
                 $this->em->flush();

                 $this->em->getConnection()->commit();

                 $this->addFlash('success', 'complexe supprimé avec succès');
            } catch (\Exception $e) {
                $this->em->getConnection()->rollBack();
                $this->addFlash('error', 'Erreur lors de la suppression du complexe');
            }
           
        } else {
            $this->addFlash('error', 'Token csrf invalides');
        }

        return $this->redirectToRoute('admin.complexes.index');
    }
}
