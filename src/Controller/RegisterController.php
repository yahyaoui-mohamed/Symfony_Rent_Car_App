<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\UserRegisterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserRegisterService $userRegisterService, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data->getEmail();
            $currentUser = $em->getRepository(User::class)->findBy(['email' => $email]);
            if (count($currentUser) > 0) {
                $this->addFlash("danger", "Email already used.");
            } else {
                $userRegisterService->register($user, $data);
                $this->addFlash("success", "Account created successfully.");
            }
            return $this->redirectToRoute("app_register");
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
