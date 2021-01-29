<?php

namespace App\DataFixtures;

use App\Entity\Image;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements FixtureGroupInterface
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
        $manager->persist($image1);
        $manager->flush();

        $image3 = (new Image())
            ->setContent('backside_air.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image4 = (new Image())
            ->setContent('frontsite.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image5 = (new Image())
            ->setContent('doubleback.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image6 = (new Image())
            ->setContent('Front_Bluntslide.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image7 = (new Image())
            ->setContent('japan.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image8 = (new Image())
            ->setContent('methode_air.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image9 = (new Image())
            ->setContent('nose_grab.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        $image10 = (new Image())
            ->setContent('Tail_grab.jpg')
            ->setCreated(new DateTime());
        $manager->persist($image1);
        $manager->flush();

        //Reference
        $this->setReference('Image1', $image1);
        $this->setReference('Image2', $image2);
        $this->setReference('Image3', $image3);
        $this->setReference('Image4', $image4);
        $this->setReference('Image5', $image5);
        $this->setReference('Image6', $image6);
        $this->setReference('Image7', $image7);
        $this->setReference('Image8', $image8);
        $this->setReference('Image9', $image9);
        $this->setReference('Image10', $image10);

    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
