<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your name'
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Phone number'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Address'
                ]
            ])
            ->add('townCity', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Town or city'
                ],
                'label' => 'Town / City'
            ])
            ->add('pickUpLocation', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your city',
                'label' => 'Location'
            ])
            ->add('pickUpDate', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your date',
                'label' => 'Date'
            ])
            ->add('pickUpTime', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your time',
                'label' => 'Time'
            ])
            ->add('dropOffLocation', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your city',
                'label' => 'Location'
            ])
            ->add('dropOffDate', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your date',
                'label' => 'Date'
            ])
            ->add('dropOffTime', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select'
                ],
                'placeholder' => 'Select your time',
                'label' => 'Time'
            ])
            ->add('promoCode', TextType::class, [
                'attr' => [
                    'placeholder' => 'Apply promo code'
                ],
                'label' => false,
                'required' => false
            ])
            ->add("newsletter", CheckboxType::class, [
                'label' => 'I agree with sending an Marketing and newsletter emails. No spam, promissed!',
                'required' => false,
            ])
            ->add("termsConditions", CheckboxType::class)
            ->add("rentNow", SubmitType::class, [
                'attr' => [
                    'class' => 'mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
