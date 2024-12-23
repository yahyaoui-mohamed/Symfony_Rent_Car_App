<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    #[Route('/car/{id}', name: 'app_car')]
    public function index($id, EntityManagerInterface $em): Response
    {
        $recentCars = $em->getRepository(Car::class)->findBy([], null, 4);
        $recommandationCars = $em->getRepository(Car::class)->findBy([], null, 8);
        $car = $em->getRepository(Car::class)->find($id);
        return $this->render('car/index.html.twig', [
            'car' => $car,
            'recentCars' => $recentCars,
            'recommandationCars' => $recommandationCars,
        ]);
    }
}
