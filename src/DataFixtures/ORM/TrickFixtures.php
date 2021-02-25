<?php

namespace App\DataFixtures\ORM;

use App\Entity\Trick;
use App\Services\Slugify;
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
            ->setName('Tail grab')
            ->setDescription('Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.')
            ->setCreatedAt(new DateTime());
        $trick1->setSlug(Slugify::slug($trick1->getName()));
        $trick1->setCategory($this->getReference('Category1'));
        $trick1->addImage($this->getReference('Image1'));
       $trick1->addVideo($this->getReference('video1'));
        $manager->persist($trick1);
        $manager->flush();

        $trick2 = (new Trick())
            ->setName('nose grab')
            ->setDescription('saisie de la partie avant de la planche, avec la main avant.')
            ->setCreatedAt(new DateTime());
        $trick2->setSlug(Slugify::slug($trick2->getName()));
        $trick2->setCategory($this->getReference('Category1'));
        $trick2->addImage($this->getReference('Image2'));
        $trick2->addVideo($this->getReference('video2'));
        $manager->persist($trick2);
        $manager->flush();

        $trick3 = (new Trick())
            ->setName('double back flip')
            ->setDescription('Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes.')
            ->setCreatedAt(new DateTime());
        $trick3->setSlug(Slugify::slug($trick3->getName()));
        $trick3->setCategory($this->getReference('Category2'));
        $trick3->addImage($this->getReference('Image3'));
        $trick3->addVideo($this->getReference('video3'));
        $manager->persist($trick3);
        $manager->flush();



        $trick4 = (new Trick())
            ->setName('flip')
            ->setDescription('Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut).')
            ->setCreatedAt(new DateTime());
        $trick4->setSlug(Slugify::slug($trick4->getName()));
        $trick4->setCategory($this->getReference('Category5'));
        $trick4->addImage($this->getReference('Image4'));
        $trick4->addVideo($this->getReference('video4'));
        $manager->persist($trick4);
        $manager->flush();

        $trick5 = (new Trick())
            ->setName('japan air')
            ->setDescription('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside')
            ->setCreatedAt(new DateTime());
        $trick5->setSlug(Slugify::slug($trick5->getName()));
        $trick5->setCategory($this->getReference('Category3'));
        $trick5->addImage($this->getReference('Image5'));
        $trick5->addVideo($this->getReference('video5'));
        $manager->persist($trick5);
        $manager->flush();

        $trick6 = (new Trick())
            ->setName('FrontSide 360')
            ->setDescription('Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…')
            ->setCreatedAt(new DateTime());
        $trick6->setSlug(Slugify::slug($trick6->getName()));
        $trick6->setCategory($this->getReference('Category3'));
        $trick6->addImage($this->getReference('Image6'));
        $trick6->addVideo($this->getReference('video6'));
        $manager->persist($trick6);
        $manager->flush();

        $trick7 = (new Trick())
            ->setName('backside air')
            ->setDescription('Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus.')
            ->setCreatedAt(new DateTime());
        $trick7->setSlug(Slugify::slug($trick7->getName()));
        $trick7->setCategory($this->getReference('Category1'));
        $trick7->addImage($this->getReference('Image7'));
        $trick7->addVideo($this->getReference('video7'));
        $manager->persist($trick7);
        $manager->flush();

        $trick8 = (new Trick())
            ->setName('FrontSide boardslide')
            ->setDescription('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.')
            ->setCreatedAt(new DateTime());
        $trick8->setSlug(Slugify::slug($trick8->getName()));
        $trick8->setCategory($this->getReference('Category2'));
        $trick8->addImage($this->getReference('Image8'));
        $trick8->addVideo($this->getReference('video8'));
        $manager->persist($trick8);
        $manager->flush();

        $trick9 = (new Trick())
            ->setName('Front Bluntslide 270')
            ->setDescription('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.')
            ->setCreatedAt(new DateTime());
        $trick9->setSlug(Slugify::slug($trick9->getName()));
        $trick9->setCategory($this->getReference('Category5'));
        $trick9->addImage($this->getReference('Image9'));
        $trick9->addVideo($this->getReference('video9'));
        $manager->persist($trick9);
        $manager->flush();

        $trick10 = (new Trick())
            ->setName('50-50')
            ->setDescription("Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).")
            ->setCreatedAt(new DateTime());
        $trick10->setSlug(Slugify::slug($trick10->getName()));
        $trick10->setCategory($this->getReference('Category4'));
        $trick10->addImage($this->getReference('Image10'));
        $trick10->addVideo($this->getReference('video10'));
        $manager->persist($trick10);
        $manager->flush();

    }

    public function getDependencies(): array
    {
        return array(
          CategoryFixtures::class,
          ImageFixtures::class,
          VideoFixtures::class,
          UserFixtures::class,
        );
    }
}
