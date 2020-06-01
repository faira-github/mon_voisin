<?php

namespace App\Repository;

use App\Entity\ConditionFooter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ConditionFooter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConditionFooter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConditionFooter[]    findAll()
 * @method ConditionFooter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionFooterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionFooter::class);
    }

    // /**
    //  * @return ConditionFooter[] Returns an array of ConditionFooter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConditionFooter
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
