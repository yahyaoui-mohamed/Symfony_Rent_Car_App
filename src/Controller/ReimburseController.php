<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReimburseController extends AbstractController
{
    #[Route('/admin/reimburse', name: 'app_reimburse')]
    public function index(): Response
    {
        return $this->render('reimburse/index.html.twig');
    }
}
