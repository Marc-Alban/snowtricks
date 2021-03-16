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


    public function nullDefaultImage(int $id): int
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

    public function setDefaultImage(int $id): int
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


    public function findImageById(int $id): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }



    public function findAllById(int $id): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

}
