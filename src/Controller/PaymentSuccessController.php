<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentSuccessController extends AbstractController
{
    #[Route('/payment/success', name: 'app_payment_success')]
    public function index(): Response
    {
        return $this->render('payment_success/index.html.twig', [
            'controller_name' => 'PaymenSuccessController',
        ]);
    }
}
