<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $popularCars = $em->getRepository(Car::class)->findBy([], null, 4);
        $recommandationCars = $em->getRepository(Car::class)->findBy([], null, 8);
        return $this->render('index/index.html.twig', [
            'recommandationCars' => $recommandationCars,
            'popularCars' => $popularCars,
        ]);
    }
}
