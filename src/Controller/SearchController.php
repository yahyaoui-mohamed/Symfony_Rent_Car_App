<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $prefix = json_decode($request->getContent(), true)["prefix"];
        // $prefix = $request->getContent();
        $cars = $em->getRepository(Car::class)->findCarsStartingWith($prefix);
        if (!$cars) {
            return new JsonResponse([], 204);
        }

        $data = $serializer->normalize($cars, null, ['groups' => 'car_details']);

        return new JsonResponse($data);
    }
}
