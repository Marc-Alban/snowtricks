<?php

namespace App\DataFixtures\ORM;

use App\Entity\Trick;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class TrickFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $trick1 = (new Trick())
            ->setTitle('Tail grab')
            ->setDescription('Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick1->setSlug($trick1->getTitle());
        $trick1->setCategory($this->getReference('Category1'))
            ->setImage($this->getReference('Image1'))
            ->setVideo($this->getReference('video1'));
        $manager->persist($trick1);
        $manager->flush();

        $trick2 = (new Trick())
            ->setTitle('nose grab')
            ->setDescription('saisie de la partie avant de la planche, avec la main avant.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick2->setSlug($trick2->getTitle());
        $trick2->setCategory($this->getReference('Category2'))
            ->setImage($this->getReference('Image2'))
            ->setVideo($this->getReference('video2'));
        $manager->persist($trick2);
        $manager->flush();

        $trick3 = (new Trick())
            ->setTitle('double back flip')
            ->setDescription('Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick3->setSlug($trick3->getTitle());
        $trick3->setCategory($this->getReference('Category3'))
            ->setImage($this->getReference('Image3'))
            ->setVideo($this->getReference('video3'));
        $manager->persist($trick3);
        $manager->flush();

        $trick4 = (new Trick())
            ->setTitle('flip')
            ->setDescription('Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut).')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick4->setSlug($trick4->getTitle());
        $trick4->setCategory($this->getReference('Category4'))
            ->setImage($this->getReference('Image4'))
            ->setVideo($this->getReference('video4'));
        $manager->persist($trick4);
        $manager->flush();

        $trick5 = (new Trick())
            ->setTitle('japan air')
            ->setDescription('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick5->setSlug($trick5->getTitle());
        $trick5->setCategory($this->getReference('Category5'))
            ->setImage($this->getReference('Image5'))
            ->setVideo($this->getReference('video5'));
        $manager->persist($trick5);
        $manager->flush();

        $trick6 = (new Trick())
            ->setTitle('frontsite 360')
            ->setDescription('Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick6->setSlug($trick6->getTitle());
        $trick6->setCategory($this->getReference('Category6'))
            ->setImage($this->getReference('Image6'))
            ->setVideo($this->getReference('video6'));
        $manager->persist($trick6);
        $manager->flush();

        $trick7 = (new Trick())
            ->setTitle('backside air')
            ->setDescription('Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick7->setSlug($trick7->getTitle());
        $trick7->setCategory($this->getReference('Category7'))
            ->setImage($this->getReference('Image7'))
            ->setVideo($this->getReference('video7'));
        $manager->persist($trick7);
        $manager->flush();

        $trick8 = (new Trick())
            ->setTitle('frontsite boardslide')
            ->setDescription('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick8->setSlug($trick8->getTitle());
        $trick8->setCategory($this->getReference('Category1'))
            ->setImage($this->getReference('Image8'))
            ->setVideo($this->getReference('video8'));
        $manager->persist($trick8);
        $manager->flush();

        $trick9 = (new Trick())
            ->setTitle('Front Bluntslide 270')
            ->setDescription('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick9->setSlug($trick9->getTitle());
        $trick9->setCategory($this->getReference('Category2'))
            ->setImage($this->getReference('Image9'))
            ->setVideo($this->getReference('video9'));
        $manager->persist($trick9);
        $manager->flush();

        $trick10 = (new Trick())
            ->setTitle('50-50')
            ->setDescription("Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).")
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $trick10->setSlug($trick10->getTitle());
        $trick10->setCategory($this->getReference('Category1'))
            ->setImage($this->getReference('Image10'))
            ->setVideo($this->getReference('video10'));
        $manager->persist($trick10);
        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
          CategoryFixtures::class,
          ImageFixtures::class,
          VideoFixtures::class,
          UserFixtures::class,
        );
    }
}
