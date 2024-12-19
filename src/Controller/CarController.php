<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    #[Route('/car/{id}', name: 'app_car')]
    public function index($id, EntityManagerInterface $em): Response
    {
        $car = $em->getRepository(Car::class)->find($id);
        return $this->render('car/index.html.twig', [
            'car' => $car
        ]);
    }
}
