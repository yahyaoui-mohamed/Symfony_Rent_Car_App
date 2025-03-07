<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TermsConditionsController extends AbstractController
{
    #[Route('/terms-conditions', name: 'app_terms_conditions')]
    public function index(): Response
    {
        return $this->render('terms_conditions/index.html.twig');
    }
}
