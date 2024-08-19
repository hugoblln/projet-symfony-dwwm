<?php

namespace App\Controller\Security;

use App\Entity\Users;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }
    #[Route('/login', 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $auth): Response
    {
        return $this->render('/Security/login.html.twig', [
            'error' => $auth->getLastAuthenticationError(),
            'lastUserName' => $auth->getLastUsername()
        ]);
    }

    #[Route('/profil', 'app.profile', methods: ['GET', 'POST'])]
    public function profil(Request $request): Response|RedirectResponse
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->issubmitted() and $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'informations modifier avec succès');

            return $this->redirectToRoute('app.index');
        }


        return $this->render('Security/profil.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }
}
