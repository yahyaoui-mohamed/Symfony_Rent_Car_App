<?php

namespace App\Controller;

use DateTime;
use App\Entity\Car;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $visitorId = $request->cookies->get('visitor_id');

        $result = (json_decode($request->getContent(), true));
        $newReview = new Review();
        $fullname = $result["fullname"];
        $review = $result["review"];
        $carId = $result["carId"];
        $car = $em->getRepository(Car::class)->find($carId);
        $newReview->setFullName($fullname);
        $newReview->setReview($review);
        $newReview->setCar($car);
        $newReview->setDate(new DateTime());
        $newReview->setVisitorId($visitorId);
        $em->persist($newReview);
        $em->flush();
        return new Response("Review Added", 200);
    }
}
