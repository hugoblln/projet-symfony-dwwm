<?php

namespace App\Controller\Frontend;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[Route('/contact', 'app.contact')]
class ContactController extends AbstractController
{
    #[Route('', '.index', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $name = $data['name'];
                $address = $data['email'];
                $phone = $data['phone'];
                $message = $data['message'];


                $email = (new Email)
                    ->from($address)
                    ->to('hugobellin@yahoo.com')
                    ->subject('Nouveau message de contact')
                    ->text("Nom: $name\nEmail: $address\nTéléphone: $phone\nMessage: $message");

                $mailer->send($email);
                $this->addFlash('success', 'L\'email a bien été envoyé.');

                return $this->redirectToRoute('app.contact');
            }
        } catch (TransportExceptionInterface $e) {
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'email.');
        }


        return $this->render('Frontend/Contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
