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

class CarsController extends AbstractController
{
    #[Route('/cars', name: 'app_cars')]
    public function index(EntityManagerInterface $em): Response
    {
        $cars = $em->getRepository(Car::class)->findAll();
        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/cars/filter', name: 'app_cars_filter')]
    public function filter(Request $request, CarRepository $carRepository): Response
    {
        // $filters = $request->query->all();
        // $cars = $carRepository->findByFilters($filters);

        // return $this->json([
        //     'html' => $this->renderView('cars/_list.html.twig', ['cars' => $cars]),
        // ]);

        $filters = json_decode($request->getContent(), true);
        // $filters = $request->query->all(); // Get filters from the request
        $cars = $carRepository->findByFilters($filters);

        $html = $this->renderView('cars/_list.html.twig', ['cars' => $cars]);

        return new Response($html);
    }
}
