<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InboxController extends AbstractController
{
    #[Route('/admin/inbox', name: 'app_inbox')]
    public function index(): Response
    {

        return $this->render('inbox/index.html.twig');
    }
}
