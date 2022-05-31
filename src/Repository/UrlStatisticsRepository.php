<?php

namespace App\Repository;

use App\Entity\UrlStatistics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UrlStatistics>
 *
 * @method UrlStatistics|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlStatistics|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlStatistics[]    findAll()
 * @method UrlStatistics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlStatisticsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlStatistics::class);
    }

    public function add(UrlStatistics $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UrlStatistics $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
