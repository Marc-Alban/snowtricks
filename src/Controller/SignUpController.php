<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    /**
     * @Route("signup", name="login")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/signUp.html.twig', [
            'current_menu' => 'signUp',
        ]);
    }
}
