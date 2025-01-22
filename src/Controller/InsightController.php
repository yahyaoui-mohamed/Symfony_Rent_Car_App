<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Transaction;
use App\Repository\CarRepository;
use App\Repository\TransactionRepository;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InsightController extends AbstractController
{
    #[Route('/admin/insight', name: 'app_insight')]
    public function index(ChartBuilderInterface $chartBuilder, EntityManagerInterface $em, TransactionRepository $transactionRepository): Response
    {
        $revenue = $em->getRepository(Transaction::class)->getTotalRevenue();
        $rents = $em->getRepository(Transaction::class)->findAll();
        $cars = $em->getRepository(Car::class)->findAll();

        $topRendterCars = $transactionRepository->getRentedCars();
        $types = array_map(fn($car) => $car['car_name'], $topRendterCars);
        $totals = array_map(fn($car) => $car['rental_count'], $topRendterCars);

        $lastDays = $em->getRepository(Transaction::class)->getTransactionsLastDays(60);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart1 = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

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

        $chart1->setData([
            'labels' => $types,
            'datasets' => [
                [
                    'backgroundColor' => [
                        '#102E7A',
                        '#1A4393',
                        '#3D81DB',
                        '#54A6FF',
                        '#98D3FF',
                    ],
                    'data' => $totals,
                ],
            ],
        ]);

        $chart1->setOptions([
            'layout' => [
                'padding' => [
                    'top' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'right' => 0,
                ],
            ],
            'scales' => [
                'y' => [
                    'display' => false
                ],
                'x' => [
                    'display' => false
                ],
            ],
            'cutout' => '80%',
            'radius' => '60%',
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 20,
                    ],
                ],
            ],
            'spacing' => 10,
        ]);




        return $this->render('insight/index.html.twig', [
            'revenue' => $revenue,
            'rents' => count($rents),
            'cars' => count($cars),
            'chart' => $chart,
            'chart1' => $chart1,
        ]);
    }
}
