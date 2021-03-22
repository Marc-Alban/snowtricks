<?php
namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Services\ImageDefault;
use App\Services\TrickHelper;
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
     * @param TrickHelper $helper
     * @return Response
     */
    public function index(TrickRepository $trickRepository, ImageRepository $imageRepository, ImageDefault $imageDefault, EntityManagerInterface $manager,TrickHelper $helper): Response
    {
        $tricks = $trickRepository->findByRequest();
        //Boucle foreach pour récupérer un trick
        foreach ($tricks as $trick){
            //Vérification de l'image par défault et pas définit une par défault
            $helper->checkImageUpload($trick, $imageRepository);
            $mainImage = $imageRepository->findBy(['trick'=>$trick->getId()]);

            // boucle sur le tableau
            foreach ($mainImage as $image){
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
                'tricks' => $tricks,
            ]);

    }
}