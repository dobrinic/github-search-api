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
}
