<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Car;
use Stripe\PaymentIntent;
use App\Form\CheckoutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index($id, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);

        $car = $em->getRepository(Car::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            Stripe::setApiKey('sk_test_51QZHxGFVL9wIFzsNS5qhf1xmfAIKMakSAztK18P27FQWkIoqJGy0kzsCUdEwMwYfb2znp8BSe1YNVsYhfYAP5S9W00y8aRXGz0');

            $amount = $car->getPrice() * 100;
            $currency = 'usd';

            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'payment_method_types' => ['card'],
                    'metadata' => [
                        'name' => $formData['name'],
                        'phoneNumber' => $formData['phoneNumber'],
                        'address' => $formData['address'],
                    ],
                ]);

                return new JsonResponse([
                    'clientSecret' => $paymentIntent->client_secret,
                ]);
            } catch (\Exception $e) {
                return new JsonResponse(
                    [
                        'error' => $e->getMessage(),
                    ],
                    500
                );
            }
        }


        return $this->render('checkout/index.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }
}
