<?php
namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Services\ImageDefault;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @param TrickRepository $trickRepository
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function index(TrickRepository $trickRepository, ImageRepository $imageRepository): Response
    {
        $tricks = $trickRepository->findByRequest();
        $images = [];
        foreach ($tricks as $trick){
            $images[] = $imageRepository->findOneBy(['trick'=>$trick->getId()]);
        }
        $imageName = [];
        foreach ($images as $image )
        {
            if($image !== null){
                $imageName[] = true;
            }else{
                $imageName[] = false;
            }
        }
        return $this->render('pages/home.html.twig', [
            'tricks' => $trickRepository->findByRequest(),
            'imageName' => $imageName
        ]);
    }
}