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
        $user1->setEmail('millet.marcalban@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$10$GnJnlNCDHoKDA/1JSags.OfwPD7XsfQg6NUD4GfWItXo3BmmM4J1W')
            ->setEnable(true)
        ;

        $manager->persist($user1);
        $manager->flush();


        $user2 = (new User());
        $user2->setEmail('millet@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword('$2y$10$PtinEuAFlVYVhfPWM.fZzuKC7RBJLq5AFY5S1DOQXPsLSPTCCrx.y')
            ->setEnable(true)
        ;


        $manager->persist($user2);
        $manager->flush();

        //Reference
        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }

}
