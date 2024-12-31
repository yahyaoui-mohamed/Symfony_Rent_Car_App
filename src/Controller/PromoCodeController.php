<?php

namespace App\Controller;

use App\Entity\PromoCode;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PromoCodeController extends AbstractController
{
    #[Route('/admin/promocode', name: 'app_admin_promo_code')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $codes = $em->getRepository(PromoCode::class)->findAll();
        return $this->render("promo_code/index.html.twig", [
            'codes' => $codes,
        ]);
    }

    #[Route('/promocode', name: 'app_promo_code', methods: ['POST'])]
    public function getPromoCode(Request $request, EntityManagerInterface $em): Response
    {
        $result = json_decode($request->getContent(), true);
        $promoCode = $result['promoCode'];
        $days = $result['days'];
        $price = $result['price'];
        $total = $days * $price;
        $actualCode = $em->getRepository(PromoCode::class)->findOneBy(['value' => $promoCode, 'used' => 0]);
        $actualCode->setUsed(1);
        $em->flush();
        $newTotal = $total - ($total * $actualCode->getDiscountRate());
        if ($actualCode) {
            return new JsonResponse(['newTotal' => $newTotal], 200);
        } else {
            return new Response("NO", 204);
        }
    }

    #[Route('/admin/coupon/generate', name: 'app_coupon_generate')]
    public function generateCoupin(EntityManagerInterface $em): Response
    {
        $generatedCode = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 6)), 0, 6);
        $code = new PromoCode();
        $code->setValue($generatedCode);
        $code->setExpirationDate(new DateTime("+1 week"));
        $code->setDiscountRate(0.1);
        $code->setUsed(false);
        $em->persist($code);
        $em->flush($code);
        return $this->redirectToRoute("app_admin_promo_code");
    }
}
