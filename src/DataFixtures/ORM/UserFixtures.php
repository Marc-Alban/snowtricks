<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {

        //Create User----------------------------
        $user1 = (new User());
        $user1->setUsername('Marc-Alban')
            ->setPassword('@dmIn123')
            ->setEmail('millet.marcalban@gmail.com')
            ->setPhoto('jimmy-avatar.jpg')
            ->setActivated(true)
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $manager->persist($user1);
        $manager->flush();

        //Reference
        $this->addReference('user1', $user1);
    }

}
