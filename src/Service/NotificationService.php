<?php

namespace App\Service;

use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;

class NotificationService
{
  private HubInterface $hub;

  public function __construct(HubInterface $hub)
  {
    $this->hub = $hub;
  }

  public function notify()
  {
    $topic = 'https://localhost:8000/notify';

    $data = [
      'message' => 'A new car is rented !',
      'time' => date('Y-m-d H:i:s'),
      'private' => true
    ];

    $update = new Update($topic, json_encode($data));

    $this->hub->publish($update);
  }
}
