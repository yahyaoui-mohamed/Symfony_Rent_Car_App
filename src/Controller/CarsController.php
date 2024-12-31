<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Favorite;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarsController extends AbstractController
{
    #[Route('/cars', name: 'app_cars')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $visitorId = $request->cookies->get('visitor_id');
        $favoriteCarUser = $em->getRepository(Favorite::class)->findBy(["visitor_id" => $visitorId]);

        $cars = $em->getRepository(Car::class)->findAll();
        $queryType = $em->createQuery(
            'SELECT c.type, COUNT(c.id) as car_count 
            FROM App\Entity\Car c
            GROUP BY c.type'
        );

        $queryCapacity = $em->createQuery(
            'SELECT c.capacity, COUNT(c.id) as car_count
             FROM App\Entity\Car c
             GROUP BY c.capacity
             ORDER BY c.capacity'
        );

        $max = $em->getRepository(Car::class)->getMaxCarPrice();

        $carDataCapacity = $queryCapacity->getResult();
        $carDataType = $queryType->getResult();

        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
            'carDataType' => $carDataType,
            'carDataCapacity' => $carDataCapacity,
            'favoriteCarUser' => $favoriteCarUser,
            'max' => $max,
        ]);
    }

    #[Route('/cars/filter', name: 'app_cars_filter')]
    public function filter(Request $request, CarRepository $carRepository, EntityManagerInterface $em): Response
    {
        $visitorId = $request->cookies->get('visitor_id');
        $favoriteCarUser = $em->getRepository(Favorite::class)->findBy(["visitor_id" => $visitorId]);
        $filters = json_decode($request->getContent(), true);
        $cars = $carRepository->findByFilters($filters);
        $html = $this->renderView('cars/_list.html.twig', [
            'cars' => $cars,
            'favoriteCarUser' => $favoriteCarUser,
        ]);

        return new Response($html);
    }
}
