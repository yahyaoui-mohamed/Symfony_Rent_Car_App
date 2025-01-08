<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddCarController extends AbstractController
{
    #[Route('admin/add', name: 'app_add_car')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('img')->getData();
            $otherImgs = $form->get('other_img')->getData();
            $otherImages = [];
            foreach ($otherImgs as $otherImg) {
                $otherImgName = $otherImg->getClientOriginalName();
                $otherImgPath = $this->getParameter('car_path') . $otherImgName;
                $otherImg->move(
                    $this->getParameter('car_directory'),
                    $otherImgName
                );
                $otherImages[] = $otherImgPath;
            }
            $imgName = $img->getClientOriginalName();
            $imgPath = $this->getParameter('car_path') . $imgName;
            $img->move(
                $this->getParameter('car_directory'),
                $imgName
            );
            $car->setImg($imgPath);
            $car->setOtherImg($otherImages);
            $em->persist($car);
            $em->flush();
            $this->addFlush("success", "Car added.");
            return $this->redirectToRoute("app_add_car");
        }
        return $this->render('add_car/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
