<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminSettingsController extends AbstractController
{
    #[Route('/admin/settings', name: 'app_admin_settings')]
    public function index(): Response
    {
        return $this->render('admin_settings/index.html.twig');
    }
}
