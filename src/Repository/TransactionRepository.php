<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getTotalRevenue(): float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('SUM(c.total)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTransactionsLastDays(int $days): array
    {
        $lastDays = new \DateTime('-' . $days . ' days');
        $lastDays->setTime(0, 0, 0);

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('total', 'total');

        // Modified SQL query
        $sql = "SELECT DATE_FORMAT(creation_date, '%m/%d') AS date, SUM(total) AS total " .
            "FROM transaction " .
            "WHERE creation_date >= :lastDays " .
            "GROUP BY DATE(creation_date) " . // Group by month/day
            "ORDER BY DATE(creation_date) ASC"; // Order by month/day

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter('lastDays', $lastDays);

        $results = $query->getResult();

        $dates = [];
        $counts = [];

        foreach ($results as $result) {
            $dates[] = $result['date'];
            $counts[] = $result['total'];
        }

        return [$dates, $counts];
    }

    public function getRentedCars(): array
    {
        $qb = $this->createQueryBuilder('t')
            ->select('c.name AS car_name, COUNT(t.id) AS rental_count')
            ->innerJoin('t.car', 'c') // Assuming `Transaction` has a relationship to `Car` named `car`
            ->groupBy('c.name')
            ->orderBy('rental_count', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
