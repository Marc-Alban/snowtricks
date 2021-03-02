<?php


namespace App\Services;

use App\Entity\Token;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class TokenSendler extends AbstractController
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendToken(User $user, Token $token)
    {
        $email = (new Email())
            ->From('snowtrick@example.com')
            ->To($user->getEmail())
            ->html(
                $this->twig->render(
                    'emails/registerEmail.html.twig',
                    ['token' => $token->getValue()]
                ),
                'text/html'
            );
        $this->addFlash('success', "An email has been sent to you, please confirm by clicking on it");
        $this->mailer->send($email);
    }
}