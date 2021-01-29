<?php

namespace App\DataFixtures\ORM;

use App\Entity\Image;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $image1 = (new Image())
            ->setContent('50-50.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image2 = (new Image())
            ->setContent('flip.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image2);
        $manager->flush();

        $image3 = (new Image())
            ->setContent('backside_air.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image3);
        $manager->flush();

        $image4 = (new Image())
            ->setContent('frontsite.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image4);
        $manager->flush();

        $image5 = (new Image())
            ->setContent('doubleback.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image5);
        $manager->flush();

        $image6 = (new Image())
            ->setContent('Front_Bluntslide.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image6);
        $manager->flush();

        $image7 = (new Image())
            ->setContent('japan.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image7);
        $manager->flush();

        $image8 = (new Image())
            ->setContent('methode_air.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image8);
        $manager->flush();

        $image9 = (new Image())
            ->setContent('nose_grab.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image9);
        $manager->flush();

        $image10 = (new Image())
            ->setContent('Tail_grab.jpg')
            ->setCreated(new DateTime());
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
