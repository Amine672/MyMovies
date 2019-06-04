<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\Driver\Connection;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    function findByGenre($genre){
 
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->leftJoin('m.genres', 'g')
            ->addSelect('g');

        $qb->add('where', $qb->expr()->in('g', ':g'))
            ->setParameter('g', $genre);
        
        return $qb->getQuery()->getResult();
 
    }
    
    function searchBar($key){
        $qb = $this->createQueryBuilder('m')
        ->where('m.title like :title')
        ->setParameter('title', '%'.$key.'%')
        ->setMaxResults('4')
        ->orderBy('m.title', 'ASC')
        ->getQuery();

        return $qb->getResult();
    } 

    function movieRandom(Connection $conn){
        $sql = 'SELECT id from movie ORDER BY RAND() LIMIT 20';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $random_ids = array();
        while ($id = $stmt->fetch()) {
            $random_ids[] = $id['id'];
        }
        $qb = $this->createQueryBuilder('m')
            ->where('m.id in (:ids)')
            ->setParameter('ids', $random_ids)
            ->setMaxResults('20')
            ->getQuery();
        return $qb->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
