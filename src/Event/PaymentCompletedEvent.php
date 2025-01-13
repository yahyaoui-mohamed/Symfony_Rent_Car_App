<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class PaymentCompletedEvent extends Event
{
  public const NAME = 'payment.completed';
  private array $data;

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function getData(): array
  {
    return $this->data;
  }
}
