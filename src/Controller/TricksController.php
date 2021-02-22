<?php
namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function create(Request $request, EntityManagerInterface $manager,): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get('images')->getData();
            foreach ($images as $image)
            {
                $fileName =  md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $img = new Image();
                $img->setName($fileName);
                $trick->addImage($img);
            }
            $manager->persist($trick);
            $manager->flush();
            $this->addFlash('success', 'Trick created');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pages/create.html.twig',[
            'trick' => $trick,
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/trick/{slug}",name="app_trick_show", methods="GET")
     * @param TrickRepository $trickRepository
     * @param string $slug
     * @return Response
     */
    public function show(TrickRepository $trickRepository, string $slug): Response
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

    /**
     * @Route("/trick/{slug}/edit", name="app_trick_edit", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param TrickRepository $trickRepository
     * @param string $slug
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, TrickRepository $trickRepository, string $slug): Response
    {
        $tricks = $trickRepository->findOneBySlug($slug);
        foreach ($tricks as $trick ) {
            $form = $this->createForm(TrickType::class, $trick);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $images = $form->get('images')->getData();
                foreach ($images as $image) {
                    $fileName = md5(uniqid()) . '.' . $image->guessExtension();
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                    $img = new Image();
                    $img->setName($fileName);
                    $trick->addImage($img);
                }
                $manager->flush();
                $this->addFlash('success', 'Trick updated');
                return $this->redirectToRoute('app_home');
            }
            return $this->render('pages/edit.html.twig', [
                'form' => $form->createView(),
                'trick' => $trick
            ]);
        }
    }

    /**
     * @Route("/trick/{id}/delete", name="app_trick_delete", methods={"DELETE"})
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Trick $trick
     * @return Response
     */
    public function delete(EntityManagerInterface $manager, Request $request, Trick $trick): Response
    {
        if($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))){
            $manager->remove($trick);
            $manager->flush();
        }
        $this->addFlash('info', 'trick deleted');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route ("/image/{id}/delete", name="app_delete_image", methods={"DELETE"})
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token']))
        {
            $nom = $image->getName();
            unlink($this->getParameter('images_directory').'/'.$nom);
            $manager->remove($image);
            $manager->flush();

            return new JsonResponse(['success'=>1]);
        }else{
            return new JsonResponse(['error'=>'Token invalid'], 400);
        }
    }

    /**
     * @Route ("/video/{id}/delete", name="app_delete_video", methods={"DELETE"})
     * @param Video $video
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    public function deleteVideo(Video $video, Request $request, EntityManagerInterface $manager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('delete'.$video->getId(), $data['_token']))
        {
            $manager->remove($video);
            $manager->flush();
            return new JsonResponse(['success'=>1]);
        }else{
            return new JsonResponse(['error'=>'Token invalid'], 400);
        }
    }


    /**
     * @Route ("/video/{id}/edit", name="app_edit_video", methods={"GET", "POST"})
     * @param Video $video
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editVideo(Video $video, Request $request, EntityManagerInterface $manager): Response
    {

            $form = $this->createForm(VideoType::class, $video);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager->flush();
                $this->addFlash('success', 'Video updated');
                return $this->redirectToRoute('app_home');
            }
            return $this->render('pages/editVideo.html.twig', [
                'form' => $form->createView(),
                'video' => $video
            ]);
    }

    /**
     * @Route ("/image/{id}/edit", name="app_edit_image", methods={"GET", "POST"})
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editImage(Image $image, Request $request, EntityManagerInterface $manager): Response
    {

            $form = $this->createForm(  ImageType::class, $image);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager->flush();
                $this->addFlash('success', 'Image updated');
                return $this->redirectToRoute('app_home');
            }
            return $this->render('pages/editImage.html.twig', [
                'form' => $form->createView(),
                'image' => $image
            ]);
    }

}