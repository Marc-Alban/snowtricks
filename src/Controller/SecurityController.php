<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\TokenRepository;
use App\Services\TokenSendler;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

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
            return $this->redirectToRoute('app_login');
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




}
