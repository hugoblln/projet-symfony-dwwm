<?php

namespace App\Controller\Backend;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', 'admin.users')]
class UsersController extends AbstractController
{
    public function __construct(
        private UsersRepository $userRepo,
        private EntityManagerInterface $em
    ) 
    {    
    }

    #[Route('', '.index', methods: ['GET'])]
    public function index(): Response
    {
       

        return $this->render('Backend/Users/index.html.twig',[
            'users' => $this->userRepo->findAll()
        ]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET','POST'])]
    public function edit(?Users $user, Request $request) : Response|RedirectReponse
    {

        if(!$user) {
            $this->addFlash('error', 'utilisateur non trouvé');

            return $this->redirectToRoute('admin.users.index');
        }

        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succes');

            return $this->redirectToRoute('admin.users.index');
        }
        

        return $this->render('Backend/Users/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(Users $user, Request $request) : Response
    {
        if(!$user) {
            $this->addFlash('error', 'utilisateur non trouvé');

            return $this->redirectToRoute('admin.users.index');
        }

        if($this->isCsrfTokenValid('delete' . $user->getId(),$request->request->get('token'))) {
            $this->em->remove($user);
            $this->em->flush();

            $this->addFlash('success', 'utilisateur supprimé avec succès');

            
        } else {
            $this->addFlash('error', 'Token csrf invalides');
        }

        return $this->redirectToRoute('admin.users.index');

    }
} 