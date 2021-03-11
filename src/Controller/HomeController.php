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
        $imageName = null;

        //Boucle foreach pour récupérer un trick
        foreach ($tricks as $trick){
            //Récupération de l'image / des images
            $images = $imageRepository->findAllById($trick->getId());
            // boucle sur le tableau
            foreach ($images as $image){

                //Vérification du fichier présents qu'il soit pas false
                    $imageName[] = [
                        'id' =>  $image->getId(),
                        'default' =>$imageDefault->index($image->getName())
                    ];
                }

            }

        foreach ($imageName as $items) {
             if($items['default'] === false){
                $image = $imageRepository->findOneBy(['id'=>$items['id']]);
                $manager->remove($image);
                $manager->flush();
            }
        }

        return $this->render('pages/home.html.twig', [
                'tricks' => $tricks,
            ]);

    }
}