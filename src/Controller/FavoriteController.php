<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod("POST")) {
            $data = json_decode($request->getContent(), true);
            $carId = $data["id"];

            $visitorId = $request->cookies->get('visitor_id');
            $car = $em->getRepository(Car::class)->find($carId);
            $favorite = new Favorite();
            $favorite->setCar($car)
                ->setVisitorId($visitorId);

            $em->persist($favorite);
            $em->flush();
            return new Response();
        } else {
            return $this->render('favorite/index.html.twig');
        }
    }
}
