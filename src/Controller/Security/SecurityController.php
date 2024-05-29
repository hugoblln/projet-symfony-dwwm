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
    #[Route('/login', 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $auth): Response
    {
        return $this->render('/Security/login.html.twig', [
            'error' => $auth->getLastAuthenticationError(),
            'lastUserName' => $auth->getLastUsername()
        ]);
    }

    #[Route('/profil', 'app.profile', methods: ['GET', 'POST'])]
    public function profil(): Response|RedirectResponse
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);



        return $this->render('Security/profil.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }
}
