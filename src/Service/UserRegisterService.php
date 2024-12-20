<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterService
{
  private EntityManagerInterface $em;
  private UserPasswordHasherInterface $hasher;

  public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
  {
    $this->em = $em;
    $this->hasher = $hasher;
  }

  public function register($user, $data): void
  {
    $password = $data->getPassword();
    $hashedPass = $this->hasher->hashPassword($user, $password);
    $user->setPassword($hashedPass);
    $this->em->persist($user);
    $this->em->flush();
  }
}
