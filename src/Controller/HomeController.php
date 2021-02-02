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
     * @Route("/", name="app_home")
     * @param TrickRepository $trick
     * @param ImageRepository $images
     * @return Response
     */
    public function index(TrickRepository $trick, ImageRepository $images): Response
    {

        return $this->render('pages/home.html.twig', [
            'tricks' => $trick->findAll(),
            'images' => $images->findAll()
        ]);
    }
}