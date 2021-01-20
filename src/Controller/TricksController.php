<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

    /**
     * @Route("/tricks", name="trick_index", methods={"POST","GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('categorie', ChoiceType::class)
            ->add('content', TextType::class)
            ->add('url', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);


//            if($form->isSubmitted() && $form->isValid()){
//               //Get datas
//                $data = $form->getData();
//               //Categorie
//                $categorie = (new Category());
//                $categorie->setName($data['categorie']);
//                $em->persist($categorie);
//                $em->flush();
//                //Trick
//                $trick = (new Trick());
//                $trick->setTitle($data['title'])
//                    ->setDescription($data['description'])
//                    ->setCreated(new DateTime())
//                    ->setLastUpdate(new DateTime())
//                    ->setCategory($categorie);
//                $trick->setSlug($trick->getTitle());
//                $em->persist($trick);
//                $em->flush();
//                //Image
//                $image = (new Image())
//                    ->setContent($data['content'])
//                    ->setTrick($trick)
//                    ->setCreated(new DateTime());
//                $em->persist($image);
//                $em->flush();
//                //Video
//                $video = (new Video())
//                    ->setAddress($data['url'])
//                    ->setTrick($trick)
//                    ->setCreated(new DateTime());
//                $em->persist($video);
//                $em->flush();
//            }


        return $this->render('pages/tricks.html.twig', [
                'current_menu'=>'tricks',
                'form'=>$form->createView()
            ]);
    }
}