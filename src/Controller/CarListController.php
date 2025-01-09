<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CarListController extends AbstractController
{
    #[Route('/admin/cars', name: 'app_car_list')]
    public function index(EntityManagerInterface $em): Response
    {
        $cars = $em->getRepository(Car::class)->findAll();

        return $this->render('car_list/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'app_car_edit')]
    public function edit(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $car = $em->getRepository(Car::class)->find($id);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }
        return $this->render('car_list/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'app_car_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $car = $em->getRepository(Car::class)->find($id);
        $em->remove($car);
        $em->flush();
        return $this->redirectToRoute("app_car_list");
    }
}
