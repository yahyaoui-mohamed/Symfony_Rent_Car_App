<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Car;
use App\Entity\Transaction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

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
                ->setTotal($i + 1)
                ->setVisitorId(uniqid())
                ->setDays($i + 1)
                ->setCreationDate(new DateTime());
            $manager->persist($transaction);
        }

        $manager->flush();
    }
}
