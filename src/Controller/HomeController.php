<?php
namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(TrickRepository $trick, ImageRepository $images): Response
    {

        return $this->render('pages/home.html.twig', [
            'current_menu'=>'home',
            'tricks' => $trick->findAll(),
            'images' => $images->findAll()
        ]);
    }
}