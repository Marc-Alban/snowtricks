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
     * @param Image $image
     * @param ImageRepository $imageRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function defaultImage(Image $image, ImageRepository $imageRepository, EntityManagerInterface $manager): Response
    {

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

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

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }
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
                return $this->redirectToRoute('app_home', [
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

        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

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
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function delete(EntityManagerInterface $manager, Request $request, Trick $trick, ImageRepository $imageRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        $images = $imageRepository->removeImageId($trick->getId());
        foreach ($images as $image){
                unlink($this->getParameter('images_directory').$image->getName());
                $manager->remove($image);
                $manager->flush();
        }

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
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        }

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
        $tricks = $trickRepository->findOneBySlug($slug);
        $user = $this->getUser();

            if($tricks){
                foreach ($tricks as $trick){
                    $comments = $commentRepository->findBy(['trick'=>$trick->getId()]);
                    $image = $imageRepository->findOneBy(['trick'=>$trick->getId()]);
                    if($image !== null){
                        $imageName = $imageDefault->index($image->getName());
                    }else{
                        $imageName = false;
                    }

                    $helper->checkImageUpload($trick, $imageRepository);
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

                        return $this->render('pages/show.html.twig', [
                            'trick' => $trick,
                            'imageName' => $imageName,
                            'form' => $form->createView(),
                            'comments' => $comments,
                        ]);
                }
            }

        throw $this->createNotFoundException('le trick n\'existe pas !');
    }


}