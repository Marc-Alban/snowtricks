<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignInController extends AbstractController
{

    /**
     * @Route("signin", name="app_register")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/signIn.html.twig');
    }
}
