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

    // public function getTransactionsLastDays(int $days): array
    // {
    //     $qb = $this->createQueryBuilder('t');

    //     $lastDays = new \DateTime('-' . $days . ' days');

    //     $qb->select('COUNT(t.id) as transaction_count, DATE(t.created_date')
    //         ->addSelect('t.creation_date')
    //         ->where('t.creation_date >= :lastDays')
    //         ->setParameter('lastDays', $lastDays)
    //         ->groupBy('t.creation_date')
    //         ->orderBy('t.creation_date', 'ASC');

    //     return $qb->getQuery()->getResult();
    // }

    public function getTransactionsLastDays(int $days): array
    {
        $lastDays = new \DateTime('-' . $days . ' days');
        $lastDays->setTime(0, 0, 0);

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date');
        $rsm->addScalarResult('total', 'total');

        $sql = "SELECT DATE(creation_date) AS date, SUM(total) AS total " .
            "FROM transaction " .
            "WHERE creation_date >= :lastDays " .
            "GROUP BY DATE(creation_date) " .
            "ORDER BY DATE(creation_date) ASC";

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
}
