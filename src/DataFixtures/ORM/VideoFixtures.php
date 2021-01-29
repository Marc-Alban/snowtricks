<?php

namespace App\DataFixtures\ORM;

use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {

        $video1 = (new Video())
            ->setAddress('https://www.youtube.com/embed/_hxLS2ErMiY')
            ->setCreated(new DateTime());
       $manager->persist($video1);
       $manager->flush();

        $video2 = (new Video())
            ->setAddress('https://www.youtube.com/embed/_Qq-YoXwNQY')
            ->setCreated(new DateTime());
        $manager->persist($video2);
        $manager->flush();

        $video3 = (new Video())
            ->setAddress('https://www.youtube.com/embed/ZlNmeM1XdM4')
            ->setCreated(new DateTime());
        $manager->persist($video3);
        $manager->flush();

        $video4 = (new Video())
            ->setAddress('https://www.youtube.com/embed/CzDjM7h_Fwo')
            ->setCreated(new DateTime());
        $manager->persist($video4);
        $manager->flush();

        $video5 = (new Video())
            ->setAddress('https://www.youtube.com/embed/9T5AWWDxYM4')
            ->setCreated(new DateTime());
        $manager->persist($video5);
        $manager->flush();

        $video6 = (new Video())
            ->setAddress('https://www.youtube.com/embed/SLncsNaU6es')
            ->setCreated(new DateTime());
        $manager->persist($video6);
        $manager->flush();

        $video7 = (new Video())
            ->setAddress('https://www.youtube.com/embed/_CN_yyEn78M')
            ->setCreated(new DateTime());
        $manager->persist($video7);
        $manager->flush();

        $video8 = (new Video())
            ->setAddress('https://www.youtube.com/embed/12OHPNTeoRs')
            ->setCreated(new DateTime());
        $manager->persist($video8);
        $manager->flush();

        $video9 = (new Video())
            ->setAddress('https://www.youtube.com/embed/kxZbQGjSg4w')
            ->setCreated(new DateTime());
        $manager->persist($video9);
        $manager->flush();

        $video10 = (new Video())
            ->setAddress('https://www.youtube.com/embed/O5DpwZjCsgA')
            ->setCreated(new DateTime());
        $manager->persist($video10);
        $manager->flush();

        //Reference
        $this->addReference('video1', $video1);
        $this->addReference('video2', $video2);
        $this->addReference('video3', $video3);
        $this->addReference('video4', $video4);
        $this->addReference('video5', $video5);
        $this->addReference('video6', $video6);
        $this->addReference('video7', $video7);
        $this->addReference('video8', $video8);
        $this->addReference('video9', $video9);
        $this->addReference('video10', $video10);
    }

}
