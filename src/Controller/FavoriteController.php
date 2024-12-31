<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $visitorId = $request->cookies->get('visitor_id');

        if ($request->isMethod("DELETE")) {
            $data = json_decode($request->getContent(), true);
            $carId = $data["id"];
            $favCar = $em->getRepository(Favorite::class)->findOneBy(["car" => $carId, "visitor_id" => $visitorId]);
            $em->remove($favCar);
            $em->flush();
            return new Response("Car deleted.");
        } else if ($request->isMethod("POST")) {
            $data = json_decode($request->getContent(), true);
            $carId = $data["id"];
            $car = $em->getRepository(Car::class)->find($carId);
            $favorite = new Favorite();
            $favorite->setCar($car)
                ->setVisitorId($visitorId);

            $em->persist($favorite);
            $em->flush();
            return new Response("Car added.");
        } else {
            $favoriteCars = $em->getRepository(Favorite::class)->findBy(["visitor_id" => $visitorId]);
            return $this->render('favorite/index.html.twig', [
                'favoriteCars' => $favoriteCars
            ]);
        }
    }
}
