<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\CheckoutType;
use App\Service\StripePaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index(
        $id,
        Request $request,
        EntityManagerInterface $em,
        UrlGeneratorInterface $router // Inject the router
        ,
        SessionInterface $session
    ): Response {
        $form = $this->createForm(CheckoutType::class);
        // $form->handleRequest($request);
        $car = $em->getRepository(Car::class)->find($id);
        $visitorId = $request->cookies->get("visitor_id");

        $days = $session->get('days');
        $total = $days * $car->getPrice();

        if ($request->isMethod("POST")) {

            Stripe::setApiKey('sk_test_51QZHxGFVL9wIFzsNS5qhf1xmfAIKMakSAztK18P27FQWkIoqJGy0kzsCUdEwMwYfb2znp8BSe1YNVsYhfYAP5S9W00y8aRXGz0');

            $currency = 'usd';

            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $total * 100,
                    'currency' => $currency,
                    'payment_method_types' => ['card'],
                ]);
                $transaction = new Transaction();
                $transaction->setCar($car)
                    ->setTotal($total)
                    ->setVisitorId($visitorId)
                    ->setDays($days);
                $em->persist($transaction);
                $em->flush();
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
            'total' => $total,
            'form' => $form->createView(),
        ]);
    }
}
