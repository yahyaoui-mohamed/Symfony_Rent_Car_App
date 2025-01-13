<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use App\Event\PaymentCompletedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: PaymentCompletedEvent::NAME, method: 'onPaymentCompleted')]
class PaymentCompletedListener
{
  private $mailer;
  private $logger;

  public function __construct(MailerInterface $mailer, LoggerInterface $logger)
  {
    $this->mailer = $mailer;
    $this->logger = $logger;
  }

  public function onPaymentCompleted(PaymentCompletedEvent $event): void
  {
    $data = $event->getData();
    $email = (new TemplatedEmail())
      ->from('hamayah4@gmail.com')
      ->to("yahyaouimohamedalaa99@gmail.com")
      ->subject('Payment Confirmation')
      ->htmlTemplate('emails/payment_confirmation.html.twig')
      ->context([
        'date' => new \DateTime(),
        'name' => $data["name"],
        'car' => $data["car"],
        'amount' => $data["amount"],
        'days' => $data['days'],
      ]);

    try {
      $this->mailer->send($email);
      $this->logger->info('Payment confirmation email sent to ');
    } catch (\Exception $e) {
      $this->logger->error('Failed to send payment confirmation email: ' . $e->getMessage());
    }
  }
}
