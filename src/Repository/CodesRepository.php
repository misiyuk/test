<?php

namespace App\Repository;

use App\Entity\Codes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Codes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Codes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Codes[]    findAll()
 * @method Codes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Codes::class);
    }

    // /**
    //  * @return Codes[] Returns an array of Codes objects
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
    public function findOneBySomeField($value): ?Codes
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
