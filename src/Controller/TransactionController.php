<?php

namespace App\Controller;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{
    #[Route('/admin/transaction', name: 'app_transaction')]
    public function index(EntityManagerInterface $em): Response
    {
        $transactions = $em->getRepository(Transaction::class)->findBy([], ['creation_date' => 'DESC']);
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }
}
