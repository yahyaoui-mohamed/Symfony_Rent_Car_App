<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RentsController extends AbstractController
{
    #[Route('/admin/rents', name: 'app_rents')]
    public function index(): Response
    {
        
        return $this->render('rents/index.html.twig');
    }
}
