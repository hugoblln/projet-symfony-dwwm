<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    // Crée un lien de vérification unique et envoie un e-mail contenant ce lien à l'utilisateur.
    {
        // Utilise le service verifyEmailHelper pour générer une signature unique qui inclut le lien signé, la clé d'expiration du message, et les données d'expiration. 
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail()
        );

        //  Récupère le contexte actuel de l'e-mail, y ajoute les composants de la signature (URL signée, clé d'expiration et données d'expiration) et met à jour le contexte de l'e-mail avec ces informations.
        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    // Vérifie que le lien de vérification est valide et marque l'utilisateur comme ayant une adresse e-mail vérifiée.
    {
        // valide l'email de confirmation 
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
