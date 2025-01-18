<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    private function getUser(): User
    {
        return new User();
    }

    public function testUserIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getUser();
        $user->setEmail("user@user.com")
            ->setPassword("med");
        $errors = $container->get("validator")->validate($user);
        $this->assertEquals(0, count($errors));
    }

    public function testUserEmailIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getUser()
            ->setEmail("user@user.c");
        $errors = $container->get("validator")->validate($user);
        $this->assertEquals(1, count($errors));
    }

    public function testUserPassIsNotValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getUser()
            ->setPassword("");
        $errors = $container->get("validator")->validate($user);
        $this->assertEquals(1, count($errors));
    }
}
