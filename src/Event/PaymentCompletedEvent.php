<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class PaymentCompletedEvent extends Event
{
  public const NAME = 'payment.completed';

  protected $user;
  protected $paymentDetails;

  public function __construct() {}
}
