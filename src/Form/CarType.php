<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name'
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'placeholder' => 'Select a type',
                'choices' => [
                    'Sedan' => 'Sedan',
                    'Hatchback' => 'Hatchback',
                    'Coupe' => 'Coupe',
                    'SUV' => 'SUV',
                    'Sport' => 'Sport',
                    'Convertible' => 'Convertible',
                    'Crossover' => 'Crossover',
                    'Muslce' => 'Muslce',
                    'Station Wagon'  => 'Station Wagon',
                    'Pickup'  => 'Pickup truck',
                    'Jeep' => 'Jeep',
                    'Limousine' => 'Limousine',
                ],
            ])
            ->add('capacity', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'placeholder' => 'Select a capacity',
            ])
            ->add('steering', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select',
                    'placeholder' => 'Steering'
                ],
                'choices' => [
                    'Manual' => 'Manual',
                    'Automatic' => 'Automatic'
                ],
                'placeholder' => 'Select a steering',
            ])
            ->add('gasoline', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Gasoline'
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Price'
                ]
            ])
            ->add('img', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/*'
                ],
                'constraints' => [
                    new Assert\Image([
                        'mimeTypesMessage' => 'Please upload a valid image file.',
                    ])
                ],
                'multiple' => false
            ])
            ->add('other_img', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/*'
                ],
                'constraints' => [
                    new Assert\All([
                        'constraints' => [
                            new Assert\Image([
                                'mimeTypesMessage' => 'Please upload a valid image files.',
                            ])
                        ]
                    ])
                ],
                'multiple' => true,
                'required' => false
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
