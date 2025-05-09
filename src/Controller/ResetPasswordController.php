<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

//Ce contrôleur contient les actions pour demander une réinitialisation de mot de passe, envoyer un e-mail avec le lien de réinitialisation, et permettre à l'utilisateur de définir un nouveau mot de passe.

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // appel à la méthode processSendingPasswordResetEmail pour envoyer un e-mail avec le lien de réinitialisation.
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer,
                $translator
            );
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form,
        ]);
    }

    /**
     *Page de confirmation après qu'un utilisateur a demandé une réinitialisation de mot de passe. 
     */
    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
    //    On vérifie si un token de réinitialisation de mot de passe est stocké dans la session.
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        // On affiche la page de confirmation.
        return $this->render('reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    /**
    * Valide et traite l'URL de réinitialisation sur laquelle l'utilisateur a cliqué dans son e-mail.
     */
    #[Route('/reset/{token}', name: 'app_reset_password')]
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator, ?string $token = null): Response
    {

        // Si un token est passé dans l'URL, stockez-le dans la session.
        if ($token) {
      
            $this->storeTokenInSession($token);

            // Redirige l'utilisateur vers la page de réinitialisation de mot de passe pour nettoyer l'URL du token.
            return $this->redirectToRoute('app_reset_password');
        }

        // Récupère le token stocké dans la session.
        $token = $this->getTokenFromSession();

        // Si aucun token n'est stocké dans la session, l'utilisateur est redirigé vers la page de demande de réinitialisation de mot de passe.
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        // le token est validé et l'utilisateur est récupéré ou une exception est levée.
        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // Le token est valide; permettez à l'utilisateur de changer son mot de passe.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // supprime la demande de réinitialisation de mot de passe, le token est utilisé une seule fois.
            $this->resetPasswordHelper->removeResetRequest($token);

            // hash le mot de passe et le met à jour dans la base de données.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            // Met à jour le mot de passe de l'utilisateur.
            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            // nettoie la session après la réinitialisation du mot de passe.
            $this->cleanSessionAfterReset();


            return $this->redirectToRoute('app.index');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form,
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer, TranslatorInterface $translator): RedirectResponse
    {

        // L'e-mail soumis est utilisé pour rechercher l'utilisateur dans la base de données.
        $user = $this->entityManager->getRepository(Users::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Si l'utilisateur n'existe pas, il est redirigé vers la page de confirmation.
        if (!$user) {
            return $this->redirectToRoute('app_check_email');
        }

        // Génère un token de réinitialisation de mot de passe.
        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return $this->redirectToRoute('app_check_email');
        }

        // Envoie un e-mail à l'utilisateur avec le lien de réinitialisation de mot de passe.
        $email = (new TemplatedEmail())
            ->from(new Address('hugobellin@yahoo.com', 'loccer mail'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $mailer->send($email);

    //stockage du token de réinitialisation de mot de passe dans la session pour le vérifier ultérieurement.
        $this->setTokenObjectInSession($resetToken);

        // Redirige l'utilisateur vers la page de confirmation.
        return $this->redirectToRoute('app_check_email');
    }
}
