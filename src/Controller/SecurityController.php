<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Form\NewPassType;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Services\ResetPassword;
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
    public function logout(): void
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
     * @param TokenRepository $tokenRepository
     * @param string $value
     * @return Response
     */
    public function validationToken(EntityManagerInterface $manager, TokenRepository $tokenRepository,string $value): Response
    {

        $token = $tokenRepository->findOneBy(['value'=>$value]);
        $user = $token->getUser();


       if($token === null || $token->isValid() === false || $user->getEnable() === true ){
           $this->addFlash('danger', 'Token unknown..');
           return $this->redirectToRoute('app_home');
       }

            $user->setEnable(true);
            $user->setResetToken(null);
            $manager->flush();

        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/forgot/pass", name="app_forgotten_password")
     * @param Request $request
     * @param UserRepository $users
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EntityManagerInterface $manager
     * @param ResetPassword $resetPassword
     * @return Response
     */
    public function forgotPass(Request $request, UserRepository $users, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager, ResetPassword $resetPassword): Response
    {
        if($this->getUser()){
            $this->addFlash("danger", "you are already logged ! ");
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
                $this->addFlash('danger', 'This email address is unknown');
                // On retourne sur la page de connexion
                return $this->redirectToRoute('app_registration');
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            if($user->getEnable() === false  ){
                $userToken = $user->setResetToken($token);
                $manager->persist($userToken);
                $manager->flush();
                ////////////////////////////////////
                /// Renvoie d'um email pour reset password
                $resetPassword->resetMail($token,$user, $mailer);
                $this->addFlash('success', 'A new token has send on you email');
                return $this->redirectToRoute('app_home');
                ////////////////////////////////////
                }

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
            $resetPassword->resetMail($token,$user, $mailer);
            // On crée le message flash de confirmation
            $this->addFlash('success', 'Sent password reset email !');

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
            $this->addFlash('danger', 'Token false ..');
            return $this->redirectToRoute('app_login');
        }

        $userBdd = null;
        // On cherche un utilisateur avec le token donné
        foreach($users->findOneByToken($token) as $oneUser){
            $userBdd = $oneUser;
        }

            // Si l'utilisateur n'existe pas
            if ($userBdd === null) {
                // On affiche une erreur
                $this->addFlash('danger', 'User unknown');
                return $this->redirectToRoute('app_registration');
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
                $this->addFlash('success', 'Updated Password');

                // On redirige vers la page de connexion
                return $this->redirectToRoute('app_home');
            }

           // Si on n'a pas reçu les données, on affiche le formulaire
           return $this->render('security/reset_password.html.twig', ['token' => $token, 'form'=>$form->createView()]);
    }

}
