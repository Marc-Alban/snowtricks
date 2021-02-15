<?php
namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

    /**
     * @Route("/trick/create",name="app_trick_create", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Image $image
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, Image $image): Response
    {
        $form = $this->createForm(TrickType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $path = $this->getParameter('kernel.project_dir').'/public/images/';
            $trick = $form->getData();
            $image->setPath($path);
            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Trick created');
            return $this->redirectToRoute('app_trick_show', ['slug'=>$trick->getSlug()]);
        }
        return $this->render('pages/create.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/trick/{id<[0-9]+>}/delete", name="app_trick_delete", methods={"DELETE"})
     * @param Request $request
     * @param Trick $trick
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Request $request,Trick $trick,EntityManagerInterface $manager): Response
    {

        if($this->isCsrfTokenValid('trick_delete'.$trick->getId(),$request->request->get('csrf_token'))){
            $manager->remove($trick);
            $manager->flush();
            $this->addFlash('info', 'trick deleted');
        }
        return $this->redirectToRoute('app_home');
    }


    /**
     * @Route("/trick/{slug}/edit", name="app_trick_edit", methods={"GET","PUT"})
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Trick $trick, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(TrickType::class,$trick,[
            'method'=>'PUT'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            $this->addFlash('success', 'Trick updated');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/edit.html.twig',[
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/trick/{slug}",name="app_trick_show", methods="GET")
     * @param TrickRepository $trickRepository
     * @param $slug
     * @return Response
     */
    public function show(TrickRepository $trickRepository, $slug): Response
    {
        $trick = $trickRepository->findOneBySlug($slug);
        if($trick){
            foreach ($trick as $tricks){
                return $this->render('pages/show.html.twig',[
                    'trick'=>$tricks
                ]);
            }
        }
        throw $this->createNotFoundException('le trick n\'existe pas !');
    }



}