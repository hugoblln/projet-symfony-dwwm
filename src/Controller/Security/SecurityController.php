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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login','app.login', methods: ['GET','POST'])]
    public function login(AuthenticationUtils $auth) : Response
    { 
        return $this->render('/Security/login.html.twig',[
            'error' => $auth->getLastAuthenticationError(),
            'lastUserName' => $auth->getLastUsername()
        ]);
    }

    #[Route('/register','app.register', methods: ['GET','POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher,EntityManagerInterface $em): Response|RedirectResponse
    {

        $user = new Users;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user
              ->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));
        
              $em->persist($user);
              $em->flush();
      
          $this->addFlash('success', 'félicitation, vous ètes bien iscrit sur notre site');

          return $this->redirectToRoute('app.login');

        }



        return $this->render('/Security/register.html.twig',[
            'form' => $form
        ]);
    }
}