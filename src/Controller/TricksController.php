<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentaireType;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Services\ImageDefault;
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

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

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
     * @param ImageRepository $imageRepository
     * @param EntityManagerInterface $manager
     * @param int $id
     * @return Response
     */
    public function defaultImage(ImageRepository $imageRepository, EntityManagerInterface $manager, int $id): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        $imageAfterClick = $imageRepository->findOneBy(['id'=>$id]);
        $trick = $imageAfterClick->getTrick();
        $imageDefault = $imageRepository->findImageByIdTrick($trick->getId());
        foreach ($imageDefault as $image){
            $imageRepository->nullDefaultImage($image->getId());
        }
        $imageRepository->setDefaultImage($imageAfterClick->getId());
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

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }
            $trick = $trickRepository->findOneBy(['slug'=>$slug]);

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
                return $this->redirectToRoute('app_home', [
                    'slug' => $slug
                ] );
            }
            return $this->render('pages/edit.html.twig', [
                'form' => $form->createView(),
                'trick' => $trick
            ]);

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

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        $videos = $videoRepository->videoGet($id);
        $video = null;
        foreach ($videos as $oneVideo){
            $video = $oneVideo;
        }
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

    //Delete

    /**
     * @Route("/trick/{id}/delete", name="app_trick_delete", methods={"DELETE"})
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Trick $trick
     * @param ImageRepository $imageRepository
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function delete(EntityManagerInterface $manager, Request $request, Trick $trick, ImageRepository $imageRepository, CommentRepository $commentRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        if($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))){

            $images = $imageRepository->findImageById($trick->getId());
            foreach ($images as $image){
                $nameImageBool = file_exists($this->getParameter('images_directory').$image->getName());
                if($nameImageBool !== false){
                    unlink($this->getParameter('images_directory').$image->getName());
                }
                $manager->remove($image);
            }
            $comments = $commentRepository->findCommentById($trick->getId());
            foreach ($comments as $comment){
                $manager->remove($comment);
            }

            $manager->remove($trick);
            $manager->flush();
        }

        $this->addFlash('info', 'trick deleted');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route ("/image/{id}/delete", name="app_delete_image", methods={"DELETE"})
     * @param ImageRepository $imageRepository
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteImage(ImageRepository $imageRepository, int $id,Request $request, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        $imageAfterClick = $imageRepository->findOneBy(['id'=>$id]);
        $nameImageBool = file_exists($this->getParameter('images_directory').$imageAfterClick->getName());
        if($this->isCsrfTokenValid('delete'.$imageAfterClick->getId(), $request->request->get('_token'))){
            if($nameImageBool !== false){
                unlink($this->getParameter('images_directory').$imageAfterClick->getName());
            }
            $manager->remove($imageAfterClick);
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
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        if($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))){
            $manager->remove($video);
            $manager->flush();
        }
        $this->addFlash('info', 'video deleted');
        return $this->redirectToRoute('app_home');
    }

    //Show

    /**
     * @Route("/trick/{slug}",name="app_trick_show", methods={"GET","POST"})
     * @param TrickRepository $trickRepository
     * @param CommentRepository $commentRepository
     * @param TrickHelper $helper
     * @param string $slug
     * @param ImageRepository $imageRepository
     * @param ImageDefault $imageDefault
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(TrickRepository $trickRepository,CommentRepository $commentRepository, TrickHelper $helper, string $slug, ImageRepository $imageRepository, ImageDefault $imageDefault, Request $request, EntityManagerInterface $manager): Response
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $user = $this->getUser();

        //Si il y a des tricks
        if(!$trick){
            throw $this->createNotFoundException('le trick n\'existe pas !');
        }

        //Verification de l'image par default
        $helper->checkImageUpload($trick, $imageRepository);
        $imageMain = $imageRepository->findImageByIdTrick($trick->getId());
        //Recuperation des images lies au trick non principal
        $images = $imageRepository->findImageNoStarById($trick->getId());
            foreach ($images as $image){
                //Vérification du fichier présents qu'il soit pas false
                $imageName = $imageDefault->index($image->getName());
                //Si pas de true pour imageName, image n'existe pas .. Du coups on supprime l'image
                if($imageName === false){
                    unlink($this->getParameter('images_directory').$image->getName());
                    $manager->remove($image);
                    $manager->persist($image);
                    $manager->flush();
                }
            }

            $comment = new Comment();
            $form = $this->createForm(CommentaireType::class, $comment);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                    $comment->setTrick($trick);
                    $comment->setCreated(new \DateTime('now'));
                    $comment->setUser($user);
                    $manager->persist($comment);
                    $manager->flush();
                $this->addFlash('success','Comment send');
                return $this->redirectToRoute('app_trick_show', ['slug'=>$trick->getSlug()]);
            }
            //Récupération des commentaires
            $comments = $commentRepository->findBy(['trick'=>$trick->getId()], ['id'=>'DESC']);

            return $this->render('pages/show.html.twig', [
                    'trick' => $trick,
                    'imageMain' => $imageMain,
                    'images'=> $images,
                    'form' => $form->createView(),
                    'comments' => $comments,
                ]);
    }

}