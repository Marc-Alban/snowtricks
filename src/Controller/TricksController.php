<?php
namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use App\Services\TrickHelper;
use App\Services\YoutubeValidator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

    //Create
    /**
     * @Route("/trick/create",name="app_trick_create", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param TrickHelper $helper
     * @param YoutubeValidator $youtubeValidator
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, TrickHelper $helper, YoutubeValidator $youtubeValidator): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $trick->setCreatedAt(new DateTime());
            $images = $form->get('images')->getData();
            $helper->imageUpload($trick, $images);
            $videos = $form->get('videos')->getData();
            foreach ($videos as $video){
                $youtubeValidator->setVideoUrl($video, null);
                $video->setTrick($trick);
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

    //Default Image
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

    // Edit
    /**
     * @Route("/trick/{slug}/edit", name="app_trick_edit", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param TrickRepository $trickRepository
     * @param string $slug
     * @param TrickHelper $helper
     * @param YoutubeValidator $youtubeValidator
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, TrickRepository $trickRepository, string $slug, TrickHelper $helper, YoutubeValidator $youtubeValidator): Response
    {
        $tricks = $trickRepository->findOneBySlug($slug);
        foreach ($tricks as $trick ) {
            $form = $this->createForm(TrickType::class, $trick);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $trick->setUpdatedAt(new DateTime());
                $images = $form->get('images')->getData();
                $helper->imageUpload($trick, $images);
                $videos = $form->get('videos')->getData();
                foreach ($videos as $video){
                    $youtubeValidator->setVideoUrl($video, null);
                    $video->setTrick($trick);
                }
                $manager->flush();
                $this->addFlash('success', 'Trick updated');
                return $this->redirectToRoute('app_trick_show', [
                    'slug' => $slug
                ] );
            }
            return $this->render('pages/edit.html.twig', [
                'form' => $form->createView(),
                'trick' => $trick
            ]);
        }
    }

    /**
     * @Route ("/video/{id}/edit", name="app_edit_video")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param VideoRepository $videoRepository
     * @param int $id
     * @param YoutubeValidator $youtubeValidator
     * @return Response
     */
    public function editVideo(Request $request, EntityManagerInterface $manager, VideoRepository $videoRepository, int  $id, YoutubeValidator $youtubeValidator): Response
    {
        $videos = $videoRepository->videoGet($id);
        foreach ($videos as $video){
            $form = $this->createForm(VideoType::class, $video);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $url = $form->get('url')->getData();
                $youtubeValidator->setVideoUrl($video, $url);
                $manager->flush();
                $this->addFlash('success', 'video updated');
                return $this->redirectToRoute('app_trick_show', [
                    'slug' => $video->getTrick()->getSlug()
                ] );
            }
            return $this->render('pages/editVideo.html.twig',[
                'form' => $form->createView(),
                'video' => $video
            ]);
        }
    }

    //Delete
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
     * @return Response
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager): Response
    {
        if($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))){
            unlink($this->getParameter('images_directory').$image->getName());
            $manager->remove($image);
            $manager->flush();
        }
        $this->addFlash('info', 'image deleted');
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
        $this->addFlash('info', 'video deleted');
        return $this->redirectToRoute('app_home');
    }

    //Show

    /**
     * @Route("/trick/{slug}",name="app_trick_show", methods="GET")
     * @param TrickRepository $trickRepository
     * @param TrickHelper $helper
     * @param string $slug
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function show(TrickRepository $trickRepository, TrickHelper $helper, string $slug,ImageRepository $imageRepository): Response
    {
        $tricks = $trickRepository->findOneBySlug($slug);
        if($tricks){
            foreach ($tricks as $trick){
                $helper->checkImageUpload($trick, $imageRepository);
                return $this->render('pages/show.html.twig',[
                    'trick'=>$trick
                ]);
            }
        }
        throw $this->createNotFoundException('le trick n\'existe pas !');
    }


}