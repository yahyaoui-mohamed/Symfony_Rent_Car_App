<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{

    #[Route('/', name: 'app_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        $visitorId = $request->cookies->get('visitor_id');

        if (!$visitorId) {
            $visitorId = bin2hex(random_bytes(16));
            $cookie = new Cookie('visitor_id', $visitorId, strtotime('+50 years'), '/', null, true, true, false, Cookie::SAMESITE_LAX);
            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->send();
        }

        $favoriteCarUser = $em->getRepository(Favorite::class)->findBy(["visitor_id" => $visitorId]);
        $popularCars = $em->getRepository(Car::class)->findBy([], null, 8);
        $recommandationCars = $em->getRepository(Car::class)->findBy([], null, 8);

        return $this->render('index/index.html.twig', [
            'recommandationCars' => $recommandationCars,
            'popularCars' => $popularCars,
            'favoriteCarUser' => $favoriteCarUser,
        ]);
    }

    #[Route('/getCars', name: 'app_get_cars', methods: ['POST'])]
    public function getCars(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $result = json_decode($request->getContent(), true);
        $offset = $result["offset"];
        $limit = $result["limit"];

        $cars = $em->getRepository(Car::class)->findBy([], null, $limit, $offset);

        if (!$cars) {
            return new JsonResponse([], 204);
        }

        $data = $serializer->normalize($cars, null, ['groups' => 'car_details']);

        return new JsonResponse($data, 200);
    }
}
