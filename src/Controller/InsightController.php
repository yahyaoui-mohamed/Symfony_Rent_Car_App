<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InsightController extends AbstractController
{
    #[Route('/admin/insight', name: 'app_insight')]
    public function index(EntityManagerInterface $em): Response
    {
        $revenue = $em->getRepository(Transaction::class)->getTotalRevenue();
        $rents = $em->getRepository(Transaction::class)->findAll();
        $cars = $em->getRepository(Car::class)->findAll();
        return $this->render('insight/index.html.twig', [
            'revenue' => $revenue,
            'rents' => count($rents),
            'cars' => count($cars),

        ]);
    }
}
