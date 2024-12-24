<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Cookie;


class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $cookieName = 'visitor_id';

        $visitorId = $request->cookies->get($cookieName);

        if (!$visitorId) {
            $visitorId = bin2hex(random_bytes(16));

            $cookie = new Cookie(
                $cookieName,
                $visitorId,
                strtotime('+50 years'),
                '/',
                null,
                true,
                true,
                false,
                Cookie::SAMESITE_LAX
            );

            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->send();
        }
        $popularCars = $em->getRepository(Car::class)->findBy([], null, 4);
        $recommandationCars = $em->getRepository(Car::class)->findBy([], null, 8);
        return $this->render('index/index.html.twig', [
            'recommandationCars' => $recommandationCars,
            'popularCars' => $popularCars,
        ]);
    }
}
