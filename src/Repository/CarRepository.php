<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('c');

        if (isset($filters['type'])) {
            $qb->andWhere('c.type IN (:types)')
                ->setParameter('types', $filters['type']);
        }

        if (isset($filters['capacity'])) {
            $qb->andWhere('c.capacity IN (:capacities)')
                ->setParameter('capacities', $filters['capacity']);
        }

        if (isset($filters['price_min']) && isset($filters['price_max'])) {
            $qb->andWhere('c.price BETWEEN :minPrice AND :maxPrice')
                ->setParameter('minPrice', $filters['price_min'])
                ->setParameter('maxPrice', $filters['price_max']);
        }

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return Car[] Returns an array of Car objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Car
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
