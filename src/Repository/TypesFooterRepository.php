<?php

namespace App\Repository;

use App\Entity\TypesFooter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypesFooter|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypesFooter|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypesFooter[]    findAll()
 * @method TypesFooter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesFooterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypesFooter::class);
    }

    // /**
    //  * @return TypesFooter[] Returns an array of TypesFooter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypesFooter
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
