<?php

namespace App\Controller;

use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(HubInterface $hub): Response
    {

        $topic = 'https://example.com/my-private-topic';

        $data = [
            'message' => 'A new notification has been sent!',
            'time' => date('Y-m-d H:i:s'),
        ];

        $update = new Update($topic, json_encode($data));

        $hub->publish($update);

        return $this->render('notification/index.html.twig', [
            'notification' => $data,
        ]);
    }
}
