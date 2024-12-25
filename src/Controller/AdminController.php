<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Model\Chart;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chart->setData([
            'labels' => ['Sport Car', 'SU', 'Coupe', 'Hatchback', 'MPV'],
            'datasets' => [
                [
                    'backgroundColor' => [
                        '#102E7A',
                        '#1A4393',
                        '#3D81DB',
                        '#54A6FF',
                        '#98D3FF',
                    ],
                    'data' => [17439, 9478, 18197, 12510, 14406],
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
        ]);
    }
}
