<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Transaction;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InsightController extends AbstractController
{
    #[Route('/admin/insight', name: 'app_insight')]
    public function index(ChartBuilderInterface $chartBuilder, EntityManagerInterface $em): Response
    {
        $revenue = $em->getRepository(Transaction::class)->getTotalRevenue();
        $rents = $em->getRepository(Transaction::class)->findAll();
        $cars = $em->getRepository(Car::class)->findAll();

        $lastDays = $em->getRepository(Transaction::class)->getTransactionsLastDays(7);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $lastDays[0],
            'datasets' => [
                [
                    'backgroundColor' => '#3563E9',
                    'borderColor' => '#3563E9',
                    'data' => $lastDays[1],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                        'beginAtZero' => true
                    ]
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ]);


        return $this->render('insight/index.html.twig', [
            'revenue' => $revenue,
            'rents' => count($rents),
            'cars' => count($cars),
            'chart' => $chart,
        ]);
    }
}
