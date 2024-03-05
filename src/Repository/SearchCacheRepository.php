<?php

namespace App\Repository;

use App\Entity\SearchCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SearchCache>
 *
 * @method SearchCache|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchCache|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchCache[]    findAll()
 * @method SearchCache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchCacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchCache::class);
    }

//    /**
//     * @return SearchCache[] Returns an array of SearchCache objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SearchCache
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
