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
        $user1->setEmail('toto@live.fr')
            ->setUsername('toto')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$10$GnJnlNCDHoKDA/1JSags.OfwPD7XsfQg6NUD4GfWItXo3BmmM4J1W')
            ->setEnable(true)
            ->setAvatar('default_user.png')
        ;

        $manager->persist($user1);
        $manager->flush();

        //Reference
        $this->addReference('user1', $user1);
    }

}
