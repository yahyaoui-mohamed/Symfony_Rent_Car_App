<?php

namespace App\Controller;

use App\Entity\PromoCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoCodeController extends AbstractController
{
    #[Route('/promocode', name: 'app_promo_code', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $promoCode = json_decode($request->getContent(), true)['promoCode'];
        $actualCode = $em->getRepository(PromoCode::class)->findBy(['value' => $promoCode]);
        if ($actualCode) {
            return new Response("OK");
        } else {
            return new Response("NO");
        }
    }
}
