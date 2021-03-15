<?php

namespace App\Repository;

use App\Entity\Nscriptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nscriptions[]    findAll()
 * @method Nscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nscriptions::class);
    }

    // /**
    //  * @return Nscriptions[] Returns an array of Nscriptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nscriptions
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
