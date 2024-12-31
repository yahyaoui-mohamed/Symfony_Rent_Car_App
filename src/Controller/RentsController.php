<?php

namespace App\Controller;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RentsController extends AbstractController
{
    #[Route('/admin/rents', name: 'app_rents')]
    public function index(EntityManagerInterface $em): Response
    {
        $transactions = $em->getRepository(Transaction::class)->findBy([], ['creation_date' => 'DESC'], 4);

        return $this->render('rents/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }
}
