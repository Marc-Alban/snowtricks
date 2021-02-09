<?php

namespace App\DataFixtures\ORM;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {

        $image1 = (new Image())
            ->setName('50-50.jpg');
        $manager->persist($image1);
        $manager->flush();

        $image2 = (new Image())
            ->setName('flip.jpg');
        $manager->persist($image2);
        $manager->flush();

        $image3 = (new Image())
            ->setName('backside_air.jpg');
        $manager->persist($image3);
        $manager->flush();

        $image4 = (new Image())
            ->setName('frontsite.jpg');
        $manager->persist($image4);
        $manager->flush();

        $image5 = (new Image())
            ->setName('doubleback.jpg');
        $manager->persist($image5);
        $manager->flush();

        $image6 = (new Image())
            ->setName('Front_Bluntslide.jpg');
        $manager->persist($image6);
        $manager->flush();

        $image7 = (new Image())
            ->setName('japan.jpg');
        $manager->persist($image7);
        $manager->flush();

        $image8 = (new Image())
            ->setName('methode_air.jpg');
        $manager->persist($image8);
        $manager->flush();

        $image9 = (new Image())
            ->setName('nose_grab.jpg');
        $manager->persist($image9);
        $manager->flush();

        $image10 = (new Image())
            ->setName('Tail_grab.jpg');
        $manager->persist($image10);
        $manager->flush();

        //Reference
        $this->addReference('Image1', $image1);
        $this->addReference('Image2', $image2);
        $this->addReference('Image3', $image3);
        $this->addReference('Image4', $image4);
        $this->addReference('Image5', $image5);
        $this->addReference('Image6', $image6);
        $this->addReference('Image7', $image7);
        $this->addReference('Image8', $image8);
        $this->addReference('Image9', $image9);
        $this->addReference('Image10', $image10);

    }

}
