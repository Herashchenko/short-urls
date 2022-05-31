<?php

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Url>
 *
 * @method Url|null find($id, $lockMode = null, $lockVersion = null)
 * @method Url|null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]    findAll()
 * @method Url[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function add(Url $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Url $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function removeByExpirationDate()
    {
        return $this->createQueryBuilder('u')
            ->delete('App:Url', 'u')
            ->andWhere('u.expiration_date < :valDate')
            ->setParameters([
                'valDate' => date('Y-m-d')
            ])->getQuery()
            ->execute();
    }

    public function findOneByShortCodeAndByCurrentDate($value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->where('u.short_code = :val')
            ->andWhere('u.expiration_date >= :valDate')
            ->setParameters([
                'val' => $value,
                'valDate' => date('Y-m-d')
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array $value
     * @return Url[]
     */
    public function findOneByIdsAndByCurrentDate(array $value): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.id IN (:val)')
            ->andWhere('u.expiration_date >= :valDate')
            ->setParameters([
                'val' => $value,
                'valDate' => date('Y-m-d')
            ])
            ->orderBy('u.id', 'desc')
            ->getQuery()
            ->getResult();
    }
}
