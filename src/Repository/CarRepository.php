<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findNumbeOfCars(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.type, COUNT(c.id)')
            ->groupBy('c.type')
            ->orderBy('COUNT(c.id)', 'DESC');

        return $qb->getQuery()->getScalarResult();
    }


    public function findCarsStartingWith(string $prefix): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where($qb->expr()->like('u.name', ':prefix'))
            ->setParameter('prefix', $prefix . '%');
        return $qb->getQuery()->getResult();
    }

    public function getMaxCarPrice(): ?float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('MAX(c.price)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
