<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripePaymentService
{
  public function pay($total, $formData): JsonResponse
  {
    Stripe::setApiKey('sk_test_51QZHxGFVL9wIFzsNS5qhf1xmfAIKMakSAztK18P27FQWkIoqJGy0kzsCUdEwMwYfb2znp8BSe1YNVsYhfYAP5S9W00y8aRXGz0');

    $currency = 'usd';

    try {
      $paymentIntent = PaymentIntent::create([
        'amount' => $total,
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
}
