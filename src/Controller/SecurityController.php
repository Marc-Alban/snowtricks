<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Form\NewPassType;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use App\Services\TokenSendler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;


class SecurityController extends AbstractController
{

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }



    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/registration",name="app_registration")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenSendler $tokenSendler
     * @return Response
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder, TokenSendler $tokenSendler): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $passwordEncoded = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordEncoded);
            $user->setRoles(['ROLE_USER']);
            $token = new Token($user);
            $tokenSendler->sendToken($user, $token);
            $manager->persist($token);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirmation/{value}",name="app_validation")
     * @param EntityManagerInterface $manager
     * @param Token $token
     * @return Response
     */
    public function validationToken(EntityManagerInterface $manager, Token $token): Response
    {
        $user = $token->getUser();

        if($user->getEnable()){
            $this->addFlash('notice', 'The token is expired, register again');
        }else if($token->isValid()){
            $user->setEnable(true);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        $manager->remove($token);
        return $this->redirectToRoute('app_registration');
    }


    /**
     * @Route("/forgot/pass", name="app_forgotten_password")
     * @param Request $request
     * @param UserRepository $users
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function forgotPass(Request $request, UserRepository $users, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager): Response
    {
        if($this->getUser()){
            $this->addFlash("danger", "Vous êtes déjà connecté ! ");
            return $this->redirectToRoute('app_home');
        }

        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les données
            $donnees = $form->getData();

            // On cherche un utilisateur ayant cet e-mail
            $user = $users->findOneBy(['email'=>$donnees['email']]);

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

                // On retourne sur la page de connexion
                return $this->redirectToRoute('app_login');
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            // On essaie d'écrire le token en base de données
            try{
                $user->setResetToken($token);
                $user->setEnable(false);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            // On génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            // On génère l'e-mail
            $message = (new Email())
                ->From('snowtrick@example.com')
                ->To($user->getEmail())
                ->html("<p>Hello please click on this <a href=".$url.">link</a> to reset the password</p> ");
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('message', 'Sent password reset email !');

            // On redirige vers la page de login
            return $this->redirectToRoute('app_login');
        }
        // On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig',['emailForm' => $form->createView()]);
    }


    /**
     * @Route("/reset/{token}", name="app_reset_password")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $manager
     * @param UserRepository $users
     * @return RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager, UserRepository $users)
    {

        if(empty($users->findOneByToken($token))){
            // On affiche une erreur
            $this->addFlash('danger', 'Token incorrect ..');
            return $this->redirectToRoute('app_login');
        }

         // On cherche un utilisateur avec le token donné
        foreach($users->findOneByToken($token) as $userBdd){
            // Si l'utilisateur n'existe pas
            if ($userBdd === null) {
                // On affiche une erreur
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app_login');
            }

            $form = $this->createForm(NewPassType::class, $userBdd);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // On supprime le token et remet le compte actif
                $userBdd->setResetToken(null);
                $userBdd->setEnable(true);
                // On chiffre le mot de passe
                $userBdd->setPassword($passwordEncoder->encodePassword($userBdd, $request->request->get("new_pass")['password']['first']));
                // On stocke
                $manager->persist($userBdd);
                $manager->flush();
                // On crée le message flash
                $this->addFlash('message', 'Updated Password');

                // On redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
            }
           // Si on n'a pas reçu les données, on affiche le formulaire
           return $this->render('security/reset_password.html.twig', ['token' => $token, 'form'=>$form->createView()]);
       }
    }

}
