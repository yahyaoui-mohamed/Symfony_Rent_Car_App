<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index($id, EntityManagerInterface $em): Response
    {
        $car = $em->getRepository(Car::class)->find($id);
        return $this->render('checkout/index.html.twig', [
            'car' => $car
        ]);
    }
}
