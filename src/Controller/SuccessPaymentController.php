<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SuccessPaymentController extends AbstractController
{
    #[Route('/success-payment', name: 'app_success_payment')]
    public function index(): Response
    {
        return $this->render('success_payment/index.html.twig', [
            'controller_name' => 'SuccessPaymentController',
        ]);
    }
}
