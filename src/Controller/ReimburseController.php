<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReimburseController extends AbstractController
{
    #[Route('/admin/reimburse', name: 'app_reimburse')]
    public function index(): Response
    {
        return $this->render('reimburse/index.html.twig', [
            'controller_name' => 'ReimburseController',
        ]);
    }
}
