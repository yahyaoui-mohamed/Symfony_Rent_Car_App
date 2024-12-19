<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
