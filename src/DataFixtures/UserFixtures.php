<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {

        //Create User----------------------------
        $user1 = (new User());
        $user1->setUsername('Marc-Alban')
            ->setPassword('@dmIn123')
            ->setEmail('millet.marcalban@gmail.com')
            ->setPhoto('jimmy-avatar.jpg')
            ->setActivated('1')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $manager->persist($user1);
        $manager->flush();

        //Reference
        $this->addReference('user1', $user1);
    }

    public static function getGroups(): array
    {
        return ['group4'];
    }
}
