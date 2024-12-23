<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InsightController extends AbstractController
{
    #[Route('/admin/insight', name: 'app_insight')]
    public function index(): Response
    {
        return $this->render('insight/index.html.twig');
    }
}
