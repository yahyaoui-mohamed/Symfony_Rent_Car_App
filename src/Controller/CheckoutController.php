<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Entity\Car;
use Stripe\PaymentIntent;
use App\Form\CheckoutType;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\NotificationService;
use App\Event\PaymentCompletedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index($id, Request $request, EntityManagerInterface $em, SessionInterface $session, NotificationService $notification, EventDispatcherInterface $eventDispatcher): Response
    {
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);
        $car = $em->getRepository(Car::class)->find($id);
        $visitorId = $request->cookies->get("visitor_id");
        $days = $session->get('days');
        $total = $days * $car->getPrice();
        $updatedTotal = $request->request->get('newTotal', $total);
        $data = "";

        if ($request->isMethod("POST")) {
            Stripe::setApiKey('sk_test_51QZHxGFVL9wIFzsNS5qhf1xmfAIKMakSAztK18P27FQWkIoqJGy0kzsCUdEwMwYfb2znp8BSe1YNVsYhfYAP5S9W00y8aRXGz0');
            $currency = 'usd';

            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $updatedTotal * 100,
                    'currency' => $currency,
                    'payment_method_types' => ['card'],
                ]);
                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $transaction = new Transaction();
                    $transaction->setCar($car)
                        ->setTotal($updatedTotal)
                        ->setVisitorId($visitorId)
                        ->setDays($days)
                        ->setCreationDate(new DateTime());
                    $em->persist($transaction);
                    $em->flush();
                }
                $paymentData = [
                    'name' => $data["name"],
                    'amount' => $updatedTotal,
                    'car' => $car,
                    'days' => $days,
                ];
                $event = new PaymentCompletedEvent($paymentData);
                $eventDispatcher->dispatch($event, PaymentCompletedEvent::NAME);
                $notification->notify();
                return new JsonResponse([
                    'clientSecret' => $paymentIntent->client_secret,
                ]);
                return $this->redirectToRoute("app_success_payment", []);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage(),], 500);
            }
        }


        return $this->render('checkout/index.html.twig', [
            'car' => $car,
            'total' => $total,
            'form' => $form->createView(),
            'days' => $days
        ]);
    }
}
