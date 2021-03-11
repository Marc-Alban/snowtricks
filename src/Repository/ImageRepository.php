<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }



    //UPDATE `image` SET `star_image` = '0' WHERE `image`.`id` = 105;
    public function nullDefaultImage($id)
    {
        return $this->createQueryBuilder('i')
            ->update()
            ->set('i.starImage', '0')
            ->where( ':id = i.id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function setDefaultImage($id)
    {
        return $this->createQueryBuilder('i')
            ->update()
            ->set('i.starImage', '1')
            ->where( ':id = i.id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }


    public function removeImageId($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }



    public function findAllById($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Image
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
