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

        $lastDays = $em->getRepository(Transaction::class)->getTransactionsLastDays(60);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $lastDays[0],
            'datasets' => [
                [
                    'borderColor' => '#3563E9',
                    'backgroundColor' => 'rgba(53, 99, 233, 0.2)',
                    'data' => $lastDays[1],
                    'fill' => true,
                    'tension' => 0.4
                ],
            ],
        ]);

        $chart->setOptions([
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'drawBorder' => false,
                        'drawTicks' => false,
                        'display' => false
                    ],
                    'ticks' => [
                        'display' => true,
                        'lineHeight' => 1.2,
                        'padding' => 10,
                        'labelOffset' => 0,
                        'align' => 'inner',
                        'font' => [
                            'family' => 'Plus Jakarta Sans',
                            'size' => 10,
                        ],
                    ],
                ],
                'y' => [
                    'grid' => [
                        'drawBorder' => false,
                        'drawTicks' => false,
                        'color' => "#f9f5fa",
                    ],
                    'ticks' => [
                        'beginAtZero' => true,
                        'display' => true,
                        'stepSize' => 1000,
                        'max' => 5000,
                        'font' => [
                            'family' => 'Plus Jakarta Sans',
                            'size' => 10,
                        ],
                        'padding' => 10,
                        'labelOffset' => 0,
                        'align' => 'inner',
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
