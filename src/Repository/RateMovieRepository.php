<?php

namespace App\Repository;

use App\Entity\RateMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RateMovie|null find($id, $lockMode = null, $lockVersion = null)
 * @method RateMovie|null findOneBy(array $criteria, array $orderBy = null)
 * @method RateMovie[]    findAll()
 * @method RateMovie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateMovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RateMovie::class);
    }

    // /**
    //  * @return RateMovie[] Returns an array of RateMovie objects
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

    public function findByUserIdAndMovieId($userId, $movieId){
        return $this->createQueryBuilder('m')
        ->select('m.id')
        ->where('m.user = :userId')
        ->andWhere('m.movie = :movieId')
        ->setParameter('userId', $userId)
        ->setParameter('movieId', $movieId)
        ->getQuery()
        ->getResult();
    }

    public function updateRate($rate, $userId, $movieId){
        $qb = $this->createQueryBuilder('m')
        ->update()
        ->set('m.rate', ':rate')
        ->set('m.user', ':userId')
        ->set('m.movie', ':movieId')
        ->setParameter('rate', $rate)
        ->setParameter('userId', $userId)
        ->setParameter('movieId', $movieId);
        
        return $qb->getQuery()->getResult();
    }

    public function insertRate($rate, $userId, $movieId){
        $qb = $this->createQueryBuilder('m')
        ->insert('m')
        ->set('m.rate', ':rate')
        ->set('m.user', ':userId')
        ->set('m.movie', ':movieId')
        ->setParameter('rate', $rate)
        ->setParameter('userId', $userId)
        ->setParameter('movieId', $movieId);
        
        return $qb->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?RateMovie
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
