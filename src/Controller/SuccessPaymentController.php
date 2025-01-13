<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessPaymentController extends AbstractController
{
    #[Route('/success-payment', name: 'app_success_payment')]
    public function index(): Response
    {
        return $this->render('success_payment/index.html.twig');
    }
}
