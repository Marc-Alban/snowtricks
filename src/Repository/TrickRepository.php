<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findByToto()
    {
        return $this->createQueryBuilder('t')
            ->addSelect('ca')
            ->addSelect('i')
            ->addSelect('v')
            ->leftJoin('t.category','ca')
            ->leftJoin('t.images','i')
            ->leftJoin('t.videos','v')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySlug(string $slug)
    {
        return $this->createQueryBuilder('t')
            ->andwhere('t.slug = :slug')
            ->setParameter('slug',$slug)
            ->getQuery()
            ->getResult()
            ;
    }

}
