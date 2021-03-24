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
            ->setName('Tailgrab.jpg')
            ->setStarImage(true);
        $manager->persist($image1);
        $manager->flush();

        $image2 = (new Image())
            ->setName('Nosegrab.jpg')
            ->setStarImage(true);
        $manager->persist($image2);
        $manager->flush();

        $image3 = (new Image())
            ->setName('Doublebackflip.jpg')
            ->setStarImage(true);
        $manager->persist($image3);
        $manager->flush();

        $image4 = (new Image())
            ->setName('Flip.jpg')
            ->setStarImage(true);
        $manager->persist($image4);
        $manager->flush();

        $image5 = (new Image())
            ->setName('Japan.jpg')
            ->setStarImage(true);
        $manager->persist($image5);
        $manager->flush();

        $image6 = (new Image())
            ->setName('Frontside.jpg')
            ->setStarImage(true);
        $manager->persist($image6);
        $manager->flush();

        $image7 = (new Image())
            ->setName('Backsideair.jpg')
            ->setStarImage(true);
        $manager->persist($image7);
        $manager->flush();

        $image8 = (new Image())
            ->setName('Fronsideboard.jpg')
            ->setStarImage(true);
        $manager->persist($image8);
        $manager->flush();

        $image9 = (new Image())
            ->setName('Frontbluntslid.jpg')
            ->setStarImage(true);
        $manager->persist($image9);
        $manager->flush();

        $image10 = (new Image())
            ->setName('50-50.jpg')
            ->setStarImage(true);
        $manager->persist($image10);
        $manager->flush();


        $image11 = (new Image())
            ->setName('mute.jpg')
            ->setStarImage(true);
        $manager->persist($image11);
        $manager->flush();

        $image12 = (new Image())
            ->setName('indy.jpg')
            ->setStarImage(true);
        $manager->persist($image12);
        $manager->flush();

        $image13 = (new Image())
            ->setName('Seatbelt.jpg')
            ->setStarImage(true);
        $manager->persist($image13);
        $manager->flush();

        $image14 = (new Image())
            ->setName('truck-driver.jpg')
            ->setStarImage(true);
        $manager->persist($image14);
        $manager->flush();

        $image15 = (new Image())
            ->setName('half-pipe.jpg')
            ->setStarImage(true);
        $manager->persist($image15);
        $manager->flush();

        $image16 = (new Image())
            ->setName('720.jpg')
            ->setStarImage(true);
        $manager->persist($image16);
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
        $this->addReference('Image11', $image11);
        $this->addReference('Image12', $image12);
        $this->addReference('Image13', $image13);
        $this->addReference('Image14', $image14);
        $this->addReference('Image15', $image15);
        $this->addReference('Image16', $image16);

    }

}
