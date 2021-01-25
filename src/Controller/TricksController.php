<?php
namespace App\Controller;


use App\Entity\Trick;
use App\Form\TrickType;
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
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(Trick::class,$trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($trick);
            $manager->flush();

            $this->addFlash('success', 'Trick successfully created');

            return $this->redirectToRoute('app_home');
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
            $this->addFlash('info', 'trick successfully deleted');
        }
        return $this->redirectToRoute('app_home');
    }


    /**
     * @Route("/trick/{id<[0-9]+>}/edit", name="app_trick_edit", methods={"GET","PUT"})
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
            $this->addFlash('success', 'Trick successfully updated');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/edit.html.twig',[
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/trick/{id<[0-9]+>}",name="app_trick_show", methods="GET")
     * @param Trick $trick
     * @return Response
     */
    public function show(Trick $trick): Response
    {
        return $this->render('pages/show.html.twig',compact('trick'));
    }



}