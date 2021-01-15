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


class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {

        //Create Category
        $categorys = [];
        $grab = (new Category());
        $grab->setName('grab');
        $categorys['grab'] = $grab;
        $manager->persist($grab);
        $rotation = (new Category());
        $rotation->setName('rotation');
        $categorys['rotation'] = $rotation;
        $manager->persist($rotation);
        $flip = (new Category());
        $flip->setName('flip');
        $categorys['flip'] = $flip;
        $manager->persist($flip);
        $slide = (new Category());
        $slide->setName('slide');
        $categorys['slide'] = $slide;
        $manager->persist($slide);
        $oneFoot = (new Category());
        $oneFoot->setName('one foot');
        $categorys['oneFoot'] = $oneFoot;
        $manager->persist($oneFoot);
        $oldScool = (new Category());
        $oldScool->setName('old school');
        $categorys['oldSchool'] = $oldScool;
        $manager->persist($oldScool);
        $rotationDesax = (new Category());
        $rotationDesax->setName('rotation désaxée');
        $categorys['rotationDesax'] = $rotationDesax;
        $manager->persist($rotationDesax);
        $manager->flush();


        //Create User
        $user = (new User());
        $user->setUsername('Marc-Alban')
            ->setPassword('@dmIn123')
            ->setEmail('millet.marcalban@gmail.com')
            ->setPhoto('jimmy-avatar.jpg')
            ->setActivated('1')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $manager->persist($user);
        $manager->flush();

        //create Tricks
        //Trick 1 -----------------------------------------------------------------------------------
        $tailGrab = (new Trick())->setTitle('Tail grab')
            ->setDescription('Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['grab']);
        $tailGrab->setSlug($tailGrab->getTitle());
        $manager->persist($tailGrab);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('tail-grab.jpg')
            ->setTrick($tailGrab)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/id8VKl9RVQw')
            ->setTrick($tailGrab)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 1----------------------------------------------------------------------------------
        //Trick 2 -----------------------------------------------------------------------------------
        $noseGrab = (new Trick())->setTitle('nose grab')
            ->setDescription('saisie de la partie avant de la planche, avec la main avant')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['grab']);
        $noseGrab->setSlug($noseGrab->getTitle());
        $manager->persist($noseGrab);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('nose-grab.jpg')
            ->setTrick($noseGrab)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_Qq-YoXwNQY')
            ->setTrick($noseGrab)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 2----------------------------------------------------------------------------------
        //Trick 3 -----------------------------------------------------------------------------------
        $methodAir = (new Trick())->setTitle('method air')
            ->setDescription('Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut). ')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['grab']);
        $methodAir->setSlug($methodAir->getTitle());
        $manager->persist($methodAir);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('method-air.jpg')
            ->setTrick($methodAir)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_hxLS2ErMiY')
            ->setTrick($methodAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 3----------------------------------------------------------------------------------
        //Trick 4 -----------------------------------------------------------------------------------
        $doubleBackFlip = (new Trick())->setTitle('double back flip')
            ->setDescription('Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes. ')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['flip']);
        $doubleBackFlip->setSlug($doubleBackFlip->getTitle());
        $manager->persist($doubleBackFlip);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('double-back-flip.jpg')
            ->setTrick($doubleBackFlip)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/ZlNmeM1XdM4')
            ->setTrick($doubleBackFlip)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 4----------------------------------------------------------------------------------
        //Trick 5 -----------------------------------------------------------------------------------
        $japanAir = (new Trick())->setTitle('japan air')
            ->setDescription('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['grab']);
        $japanAir->setSlug($japanAir->getTitle());
        $manager->persist($japanAir);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('japan-air.jpg')
            ->setTrick($japanAir)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/CzDjM7h_Fwo')
            ->setTrick($japanAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 5----------------------------------------------------------------------------------
        //Trick 6 -----------------------------------------------------------------------------------
        $frontsite360 = (new Trick())->setTitle('frontsite 360')
            ->setDescription('Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['rotation']);
        $frontsite360->setSlug($frontsite360->getTitle());
        $manager->persist($frontsite360);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('frontsite360.jpg')
            ->setTrick($frontsite360)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/9T5AWWDxYM4')
            ->setTrick($frontsite360)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 6----------------------------------------------------------------------------------
        //Trick 7 -----------------------------------------------------------------------------------
        $backsideAir = (new Trick())->setTitle('backside air')
            ->setDescription('Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['grab']);
        $backsideAir->setSlug($backsideAir->getTitle());
        $manager->persist($backsideAir);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('backside-air.jpg')
            ->setTrick($backsideAir)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_CN_yyEn78M')
            ->setTrick($backsideAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 7----------------------------------------------------------------------------------
        //Trick 8 -----------------------------------------------------------------------------------
        $frontsideBoardslide = (new Trick())->setTitle('frontsite boardslide')
            ->setDescription('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['slide']);
        $frontsideBoardslide->setSlug($frontsideBoardslide->getTitle());
        $manager->persist($frontsideBoardslide);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('frontside-boardslide.jpg')
            ->setTrick($frontsideBoardslide)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/12OHPNTeoRs')
            ->setTrick($frontsideBoardslide)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 8----------------------------------------------------------------------------------
        //Trick 9 -----------------------------------------------------------------------------------
        $fiftyfifty = (new Trick())->setTitle('50-50')
            ->setDescription('Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['slide']);
        $fiftyfifty->setSlug($fiftyfifty->getTitle());
        $manager->persist($fiftyfifty);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('50-50.jpg')
            ->setTrick($fiftyfifty)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
           $video = (new Video())
               ->setAddress('https://www.youtube.com/embed/kxZbQGjSg4w')
               ->setTrick($fiftyfifty)
               ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 9----------------------------------------------------------------------------------
        //Trick 10 -----------------------------------------------------------------------------------
        $bluntslide270 = (new Trick())->setTitle('Front Bluntslide 270')
            ->setDescription('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($categorys['slide']);
        $bluntslide270->setSlug($bluntslide270->getTitle());
        $manager->persist($bluntslide270);
        $manager->flush();
        //Image
        $image = (new Image())
            ->setContent('front-bluntslide-270.jpg')
            ->setTrick($bluntslide270)
            ->setCreated(new DateTime());
        $manager->persist($image);
        $manager->flush();
        //Video
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/O5DpwZjCsgA')
            ->setTrick($bluntslide270)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->flush();
        //End Trick 10----------------------------------------------------------------------------------
   }
}
