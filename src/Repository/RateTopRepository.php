<?php

namespace App\Repository;

use App\Entity\RateTop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RateTop|null find($id, $lockMode = null, $lockVersion = null)
 * @method RateTop|null findOneBy(array $criteria, array $orderBy = null)
 * @method RateTop[]    findAll()
 * @method RateTop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateTopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RateTop::class);
    }

    // /**
    //  * @return RateTop[] Returns an array of RateTop objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RateTop
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
