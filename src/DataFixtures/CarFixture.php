<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $name = ["Koenigsegg", "Nissan GT - R", "Rolls-Royce", "All New Rush", "CR - V", "All New Terios", "MG ZX Exclusice", "New MG ZS", "MG ZX Excite"];
        $type = ["Sport", "Sport", "Sport", "SUV", "SUV", "SUV", "Hatchback", "SU", "Hatchback"];
        $image = ["/images/cars/Car1.png", "/images/cars/Car2.png", "/images/cars/Car3.png", "/images/cars/Car4.png", "/images/cars/Car5.png", "/images/cars/Car6.png", "/images/cars/Car7.png", "/images/cars/Car8.png", "/images/cars/Car9.png"];
        $gasoline = [90, 80, 70, 70, 80, 90, 70, 80, 90];
        $steering = ["Manual", "Manual", "Manual", "Manual", "Manual", "Manual", "Electric", "Manual", "Electric"];
        $capacity = [2, 2, 4, 6, 6, 6, 4, 6, 4];
        $price = [99, 80, 96, 72, 80, 74, 76, 80, 74];
        $description = [
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
            "NISMO has become the embodiment of Nissan's outstanding performance, inspired by the most unforgiving proving ground, the \"race track\".",
        ];

        for ($i = 0; $i < 9; $i++) {
            $car = new Car();
            $car->setName($name[$i]);
            $car->setType($type[$i]);
            $car->setImg($image[$i]);
            $car->setGasoline($gasoline[$i]);
            $car->setSteering($steering[$i]);
            $car->setCapacity($capacity[$i]);
            $car->setPrice($price[$i]);
            $car->setDescription($description[$i]);
            $manager->persist($car);
            $manager->flush();
        }
    }
}
