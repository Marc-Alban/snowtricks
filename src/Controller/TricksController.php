<?php
namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="trick_index")
     * @return Response
     */
    public function index(TrickRepository $trick): Response
    {
        return $this->render('pages/tricks.html.twig', [
                'current_menu'=>'tricks',
                'tricks' => $trick->findAll()
            ]);
    }

    /**
     * @Route("/tricks/{slug}-{id}", name="trick_show", requirements={"slug":"[a-zA-Z0-9\-]*"})
     * @return Response
     */
    public function show(Trick $trick, string $slug): Response
    {
        if($trick->getSlug() !== $slug){
            $this->redirectToRoute('trick_show',[
                'id'=>$trick->getId(),
                'slug'=>$trick->getSlug()
            ], 301);
        }
        return $this->render('pages/show.html.twig', [
            'trick'=>$trick,
            'current_menu'=>'show'
            ]);
    }
}