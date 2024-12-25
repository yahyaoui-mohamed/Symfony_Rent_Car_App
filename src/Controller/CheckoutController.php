<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CheckoutType;
use App\Service\StripePaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index($id, Request $request, EntityManagerInterface $em, StripePaymentService $stripePayment, SessionInterface $session): Response
    {
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);

        $car = $em->getRepository(Car::class)->find($id);
        $days = $session->get('days');

        $total = $days * $car->getPrice();

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $stripePayment->pay($total, $formData);
        }


        return $this->render('checkout/index.html.twig', [
            'car' => $car,
            'total' => $total,
            'form' => $form->createView(),
        ]);
    }
}
