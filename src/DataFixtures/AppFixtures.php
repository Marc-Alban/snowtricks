<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{

    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //Create Category
        $grab = (new Category());
        $grab->setName('grab');
        $manager->persist($grab);
        $rotation = (new Category());
        $rotation->setName('rotation');
        $manager->persist($rotation);
        $flip = (new Category());
        $flip->setName('flip');
        $manager->persist($flip);
        $slide = (new Category());
        $slide->setName('slide');
        $manager->persist($slide);
        $oneFoot = (new Category());
        $oneFoot->setName('one foot');
        $manager->persist($oneFoot);
        $oldScool = (new Category());
        $oldScool->setName('old school');
        $manager->persist($oldScool);
        $rotationDesax = (new Category());
        $rotationDesax->setName('rotation désaxée');
        $manager->persist($rotationDesax);
    }

//
//        //Create User
//        $user = (new User());
//        $user->setUsername('Marc-Alban')
//            ->setPassword('@dmIn123')
//            ->setEmail('millet.marcalban@gmail.com')
//            ->setCreatedAt(new DateTime())
//            ->setIsVerified('1')
//            ->setImageUser(null);
//        $manager->persist($user);
//
//
//        //create Tricks
//        //Trick 1 -----------------------------------------------------------------------------------
//        $methodAir = (new Trick())->setNameTrick('Methode Air')
//            ->setDescriptionTrick('Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut). ')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('methode_air.jpg')
//            ->getTrick($methodAir)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_hxLS2ErMiY')
//            ->setTrick($methodAir);
//        $manager->persist($video);
//        $manager->persist($methodAir);
//        //End Trick 1----------------------------------------------------------------------------------
//
//        //Trick 2 -----------------------------------------------------------------------------------
//        $noseGrab = (new Trick())->setNameTrick('nose grab')
//            ->setDescriptionTrick('saisie de la partie avant de la planche, avec la main avant')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('nose-grab.jpg')
//            ->getTrick($noseGrab)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_Qq-YoXwNQY')
//            ->setTrick($noseGrab);
//        $manager->persist($video);
//        $manager->persist($noseGrab);
//        //End Trick 2----------------------------------------------------------------------------------
//
//        //Trick 3 -----------------------------------------------------------------------------------
//        $doubleBackFlip = (new Trick())->setNameTrick('double back flip')
//            ->setDescriptionTrick('Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes. ')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($flip)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('double-back-flip.jpg')
//            ->getTrick($doubleBackFlip)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/ZlNmeM1XdM4')
//            ->setTrick($doubleBackFlip);
//        $manager->persist($video);
//        $manager->persist($doubleBackFlip);
//        //End Trick 3----------------------------------------------------------------------------------
//
//        //Trick 4 -----------------------------------------------------------------------------------
//        $japanAir = (new Trick())->setNameTrick('japan air')
//            ->setDescriptionTrick('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('japan-air.jpg')
//            ->getTrick($japanAir)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/CzDjM7h_Fwo')
//            ->setTrick($japanAir);
//        $manager->persist($video);
//        $manager->persist($japanAir);
//        //End Trick 4----------------------------------------------------------------------------------
//
//        //Trick 5-----------------------------------------------------------------------------------
//        $frontsite360 = (new Trick())->setNameTrick('frontsite 360')
//            ->setDescriptionTrick('Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($rotation)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('nose-grab.jpg')
//            ->getTrick($frontsite360)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_Qq-YoXwNQY')
//            ->setTrick($frontsite360);
//        $manager->persist($video);
//        $manager->persist($frontsite360);
//        //End Trick 5----------------------------------------------------------------------------------
//
//        //Trick 6 -----------------------------------------------------------------------------------
//        $backsideAir = (new Trick())->setNameTrick('backside air')
//            ->setDescriptionTrick('Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('backside-air.jpg')
//            ->getTrick($backsideAir)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_CN_yyEn78M')
//            ->setTrick($backsideAir);
//        $manager->persist($video);
//        $manager->persist($backsideAir);
//        //End Trick 6----------------------------------------------------------------------------------
//
//        //Trick 7-----------------------------------------------------------------------------------
//        $frontsideBoardslide = (new Trick())->setNameTrick('frontsite boardslide')
//            ->setDescriptionTrick('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
//        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($slide)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('frontside-boardslide.jpg')
//            ->getTrick($frontsideBoardslide)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/12OHPNTeoRs')
//            ->setTrick($frontsideBoardslide);
//        $manager->persist($video);
//        $manager->persist($frontsideBoardslide);
//        //End Trick 7----------------------------------------------------------------------------------
//
//        //Trick 8 -----------------------------------------------------------------------------------
//        $fiftyfifty = (new Trick())->setNameTrick('50-50')
//            ->setDescriptionTrick('Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('50-50-1.jpg')
//            ->getTrick($fiftyfifty)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/kxZbQGjSg4w')
//            ->setTrick($fiftyfifty);
//        $manager->persist($video);
//        $manager->persist($fiftyfifty);
//        //End Trick 8----------------------------------------------------------------------------------
//
//        //Trick 9-----------------------------------------------------------------------------------
//        $bluntslide270 = (new Trick())->setNameTrick('Front Bluntslide 270')
//            ->setDescriptionTrick('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($slide)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('front-bluntslide.jpg')
//            ->getTrick($bluntslide270)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_Qq-YoXwNQY')
//            ->setTrick($bluntslide270);
//        $manager->persist($video);
//        $manager->persist($bluntslide270);
//        //End Trick 9----------------------------------------------------------------------------------
//
//        //Trick 10-----------------------------------------------------------------------------------
//        $tailGrab = (new Trick())->setNameTrick('Tail grab')
//            ->setDescriptionTrick('Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
//        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('tail-grab-.jpg')
//            ->getTrick($tailGrab)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/id8VKl9RVQw')
//            ->setTrick($tailGrab);
//        $manager->persist($video);
//        $manager->persist($tailGrab);
//        //End Trick 10----------------------------------------------------------------------------------
//
//        //Trick 11-----------------------------------------------------------------------------------
//        $Frontside = (new Trick())->setNameTrick('Frontside 720')
//            ->setDescriptionTrick('Dans la série des Tutoriels de Tonton Franky, on passe au Frontside 720 ou 7.2 Front, comme son nom l’indique une rotation de 2 tours en frontside.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($grab)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('frontside.jpg')
//            ->getTrick($Frontside)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://youtu.be/1vtZXU15e38')
//            ->setTrick($Frontside);
//        $manager->persist($video);
//        $manager->persist($Frontside);
//        //End Trick 11----------------------------------------------------------------------------------
//
//        //Trick 12 -----------------------------------------------------------------------------------
//        $noseGrab = (new Trick())->setNameTrick('nose grab')
//            ->setDescriptionTrick('saisie de la partie avant de la planche, avec la main avant')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($rotation)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('nose-grab.jpg')
//            ->getTrick($noseGrab)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://www.youtube.com/embed/_Qq-YoXwNQY')
//            ->setTrick($noseGrab);
//        $manager->persist($video);
//        $manager->persist($noseGrab);
//        //End Trick 12----------------------------------------------------------------------------------
//
//        //Trick 13 -----------------------------------------------------------------------------------
//        $switchBack = (new Trick())->setNameTrick('switch back 540')
//            ->setDescriptionTrick('Les choses se corsent avec ce nouvel épisode vidéo des tutos de tonton Franky : le backside 540 en mode switch.')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($rotation)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('switchBack.jpg')
//            ->getTrick($switchBack)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://youtu.be/wDoHk1Y6c-w')
//            ->setTrick($switchBack);
//        $manager->persist($video);
//        $manager->persist($switchBack);
//        //End Trick 13----------------------------------------------------------------------------------
//
//        //Trick 14 -----------------------------------------------------------------------------------
//        $ollie  = (new Trick())->setNameTrick('ollie ')
//            ->setDescriptionTrick('Le Ollie, c\'est la base du freestyle en snowboard, et ça rendra beaucoup plus fun même la piste traditionnelle. Le tutoriel vidéo de «tonton Franky» vous explique tout ça étape par étape...')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($oldScool)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('ollie.jpg')
//            ->getTrick($ollie)
//            ->addUser($user);
//        $manager->persist($image);
//        $video = (new Video())
//            ->setUrl('https://youtu.be/kOyCsY4rBH0')
//            ->setTrick($ollie);
//        $manager->persist($video);
//        $manager->persist($ollie);
//        //End Trick 14----------------------------------------------------------------------------------
//
//        //Trick 15 -----------------------------------------------------------------------------------
//        $valeflip = (new Trick())->setNameTrick('Valeflip')
//            ->setDescriptionTrick('saisie de la partie avant de la planche, avec la main avant')
//            ->setCreatedAt(new DateTime())
//            ->setCategory($rotation)
//            ->setUser($user);
//        $image = (new Image())
//            ->setNameImage('valeflip.jpg')
//            ->getTrick($valeflip)
//            ->addUser($user);
//        $manager->persist($image);
//        $manager->persist($valeflip);
//        //End Trick 15----------------------------------------------------------------------------------
//        $manager->flush();
//    }
}
