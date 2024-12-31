<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivacyPolicyController extends AbstractController
{
    #[Route('/privacy-policy', name: 'app_privacy_policy')]
    public function index(): Response
    {
        return $this->render('privacy_policy/index.html.twig');
    }
}
