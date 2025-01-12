<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\PaymentCompletedEvent;
use App\Service\NotificationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SuccessPaymentController extends AbstractController
{
    #[Route('/success-payment', name: 'app_success_payment')]
    public function index(NotificationService $notification, EventDispatcherInterface $eventDispatcher): Response
    {
        $event = new PaymentCompletedEvent();
        $eventDispatcher->dispatch($event, PaymentCompletedEvent::NAME);
        $notification->notify();
        return $this->render('success_payment/index.html.twig');
    }
}
