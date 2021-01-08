<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="trick_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/tricks.html.twig', [
                'current_menu'=>'tricks'
            ]);
    }
}