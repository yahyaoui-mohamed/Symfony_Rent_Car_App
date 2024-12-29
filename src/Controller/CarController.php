<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CarController extends AbstractController
{
    #[Route('/car/{id}', name: 'app_car')]
    public function index($id, EntityManagerInterface $em, Request $request, SessionInterface $session): Response
    {
        $visitorId = $request->cookies->get('visitor_id');
        $favCar = $em->getRepository(Favorite::class)->findOneBy(["car" => $id, "visitor_id" => $visitorId]);
        $car = $em->getRepository(Car::class)->find($id);
        $form = $this->createFormBuilder()
            ->add("days", ChoiceType::class, [
                'choices' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',

                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label' => false
            ])
            ->add("proceedToCheckOut", SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $days = $data["days"];
            $session->set('days', $days);
            return $this->redirectToRoute("app_checkout", [
                'id' => $id,
            ]);
        }
        $recentCars = $em->getRepository(Car::class)->findBy([], null, 4);
        $recommandationCars = $em->getRepository(Car::class)->findBy([], null, 8);
        return $this->render('car/index.html.twig', [
            'car' => $car,
            'recentCars' => $recentCars,
            'recommandationCars' => $recommandationCars,
            'form' => $form->createView(),
            'isFav' => $favCar !== null ? true : false,
        ]);
    }
}
