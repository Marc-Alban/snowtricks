<?php
namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Services\ImageDefault;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @param TrickRepository $trickRepository
     * @param ImageRepository $imageRepository
     * @param ImageDefault $imageDefault
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(TrickRepository $trickRepository, ImageRepository $imageRepository,ImageDefault $imageDefault, EntityManagerInterface $manager): Response
    {
        $tricks = $trickRepository->findByRequest();
        //Boucle foreach pour récupérer un trick
        foreach ($tricks as $trick){
            //Récupération de l'image / des images
            $images = $imageRepository->findImageById($trick->getId());
            // boucle sur le tableau
            foreach ($images as $image){
                //Vérification du fichier présents qu'il soit pas false
                    if($imageDefault->index($image->getName()) === false){
                        $image = $imageRepository->findOneBy(['id'=>$image->getId()]);
                        unlink($this->getParameter('images_directory').$image->getName());
                        $manager->remove($image);
                        $manager->flush();
                    }
            }
        }


        return $this->render('pages/home.html.twig', [
                'tricks' => $tricks
            ]);

    }
}