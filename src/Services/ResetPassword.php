<?php


namespace App\Services;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPassword extends AbstractController
{
    public function resetMail(string $token, User $user, Mailer$mailer): void
    {
        // On génère l'URL de réinitialisation de mot de passe
        $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
        // On génère l'e-mail
        $message = (new Email())
            ->From('snowtrick@example.com')
            ->To($user->getEmail())
            ->html("<p>Hello please click on this <a href=".$url.">link</a> to reset the password</p> ");
        $mailer->send($message);
    }
}