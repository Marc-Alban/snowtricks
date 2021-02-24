<?php
namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Services\TrickHelper;
use App\Services\VideoUpload;
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
     * @param TrickHelper $helper
     * @param VideoUpload $videoUpload
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, TrickHelper $helper, VideoUpload $videoUpload): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get('images')->getData();
            $helper->imageUpload($trick, $images);
            $test = $form->get('videos')->getData();
            dd($test);
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
     * @param TrickHelper $helper
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, TrickRepository $trickRepository, string $slug, TrickHelper $helper): Response
    {
        $tricks = $trickRepository->findOneBySlug($slug);
        foreach ($tricks as $trick ) {
            $form = $this->createForm(TrickType::class, $trick);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $images = $form->get('images')->getData();
                $helper->imageUpload($trick, $images);
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
     * @Route ("/image/{id}/delete", name="app_delete_image")
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager): Response
    {
        if($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))){
            $manager->remove($image);
            $manager->flush();
        }
        $this->addFlash('info', 'image deleted');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route ("/image/{id}/default", name="app_default_image")
     * @param Image $image
     * @param ImageRepository $imageRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function defaultImage(Image $image, ImageRepository $imageRepository, EntityManagerInterface $manager): Response
    {
        $trick = $image->getTrick();
        foreach ($trick->getImages() as $trick){
            $imageRepository->nullDefaultImage($trick->getId());
        }
        $imageRepository->setDefaultImage($image->getId());
        $manager->flush();
        $this->addFlash('info', 'image update default');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route ("/video/{id}/delete", name="app_delete_video")
     * @param Video $video
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteVideo(Video $video, Request $request, EntityManagerInterface $manager): Response
    {
        if($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))){
            $manager->remove($video);
            $manager->flush();
        }
        $this->addFlash('info', 'trick deleted');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route ("/video/{id}/edit", name="app_edit_video")
     * @param Video $video
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editVideo(Video $video, Request $request, EntityManagerInterface $manager): Response
    {

        return $this->redirectToRoute('app_home');
    }

}