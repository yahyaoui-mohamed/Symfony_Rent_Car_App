<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\CarRepository;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ChartBuilderInterface $chartBuilder, CarRepository $carRepository, EntityManagerInterface $em): Response
    {
        $recentTransactions = $em->getRepository(Transaction::class)->findBy([], ['creation_date' => 'DESC'], 4);
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $cars = $carRepository->findNumbeOfCars();
        $types = array_map(fn($car) => $car['type'], $cars);
        $totals = array_map(fn($car) => $car[1], $cars);
        
        $chart->setData([
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

        $chart->setOptions([
            'layout' => [
                'padding' => 0
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
                    'position' => 'right',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 20,
                    ],
                ],
            ],
            'spacing' => 10
        ]);

        return $this->render('admin/index.html.twig', [
            'chart' => $chart,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
