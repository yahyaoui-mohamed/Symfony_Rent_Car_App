<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Transaction;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionFixture extends Fixture
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $transaction = new Transaction();
            $car = $this->em->getRepository(Car::class)->find($i + 1);
            $transaction
                ->setCar($car)
                ->setTotal($car->getPrice() * ($i + 1))
                ->setVisitorId(uniqid())
                ->setDays($i + 1)
                ->setCreationDate(new DateTime());
            $manager->persist($transaction);
        }



        $manager->flush();
    }
}
