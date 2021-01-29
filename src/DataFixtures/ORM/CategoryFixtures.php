<?php

namespace App\DataFixtures\ORM;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {

        //Categories ----------------
        $category1 = (new Category());
        $category1->setName('grab');
        $manager->persist($category1);
        $manager->flush();

        $category2 = (new Category());
        $category2->setName('rotation');
        $manager->persist($category2);
        $manager->flush();

        $category3 = (new Category());
        $category3->setName('flip');
        $manager->persist($category3);
        $manager->flush();

        $category4 = (new Category());
        $category4->setName('slide');
        $manager->persist($category4);
        $manager->flush();

        $category5 = (new Category());
        $category5->setName('one foot');
        $manager->persist($category5);
        $manager->flush();

        $category6 = (new Category());
        $category6->setName('old school');
        $manager->persist($category6);
        $manager->flush();

        $category7 = (new Category());
        $category7->setName('rotation désaxé');
        $manager->persist($category7);
        $manager->flush();


        //Reference
        $this->addReference('Category1', $category1);
        $this->addReference('Category2', $category2);
        $this->addReference('Category3', $category3);
        $this->addReference('Category4', $category4);
        $this->addReference('Category5', $category5);
        $this->addReference('Category6', $category6);
        $this->addReference('Category7', $category7);

    }

}
