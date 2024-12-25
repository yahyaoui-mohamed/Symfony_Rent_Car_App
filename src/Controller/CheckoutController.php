<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CheckoutType;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\PaymentIntent;


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

            // Set your Stripe secret key
            Stripe::setApiKey('sk_test_51QZHxGFVL9wIFzsNS5qhf1xmfAIKMakSAztK18P27FQWkIoqJGy0kzsCUdEwMwYfb2znp8BSe1YNVsYhfYAP5S9W00y8aRXGz0');

            // Define payment amount (in cents) and currency
            $amount = $car->getPrice() * 100; // Assuming $car->getPrice() gives the price in dollars
            $currency = 'usd'; // Adjust currency as needed

            try {
                // Create a PaymentIntent
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

                // Send the PaymentIntent client_secret to the frontend
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
    #[Route('/create-checkout-session/{id}', name: 'app_create_checkout_session', methods: ['POST'])]
    public function createCheckoutSession($id, EntityManagerInterface $em): JsonResponse
    {
        $car = $em->getRepository(Car::class)->find($id);

        if (!$car) {
            return new JsonResponse(['error' => 'Car not found'], 404);
        }

        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $car->getName(),
                    ],
                    'unit_amount' => $car->getPrice() * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_success', [], Response::HTTP_SEE_OTHER),
            'cancel_url' => $this->generateUrl('app_checkout', ['id' => $id], Response::HTTP_SEE_OTHER),
        ]);

        return new JsonResponse(['id' => $session->id]);
    }
}
