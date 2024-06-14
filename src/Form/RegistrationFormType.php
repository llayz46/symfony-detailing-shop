<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', TextType::class, [
        'attr' => [
          'placeholder' => 'john@doe.fr'
        ]
      ])
      ->add('firstName', TextType::class, [
        'attr' => [
          'placeholder' => 'John',
        ],
        'label' => 'Prénom',
        'row_attr' => [
          'class' => 'w-full mb-3'
        ],
      ])
      ->add('lastName', TextType::class, [
        'attr' => [
          'placeholder' => 'Doe'
        ],
        'label' => 'Nom',
        'row_attr' => [
          'class' => 'w-full mb-3'
        ],
      ])
      ->add('agreeTerms', CheckboxType::class, [
        'mapped' => false,
        'label_html' => true,
        'label' => 'Accepter les <a href="" class="font-medium hover:underline text-primary-600">Termes et Conditions</a>',
        'constraints' => [
          new IsTrue([
            'message' => 'Veuillez accepter les termes et conditions.',
          ]),
        ],
      ])
      ->add('plainPassword', RepeatedType::class, [
        'mapped' => false,
        'type' => PasswordType::class,
        'first_options' => ['attr' => [
          'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
          'placeholder' => '••••••••'
        ], 'label' => 'Mot de passe', 'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white']],
        'second_options' => ['attr' => [
          'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
          'placeholder' => '••••••••'
        ], 'label' => 'Confirmer le mot de passe', 'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white']],
        'invalid_message' => 'Les mots de passes doivent correspondre.',
        'constraints' => [
          new NotBlank([
            'message' => 'Veuillez entrer un mot de passe.',
          ]),
          new Length([
            'min' => 6,
            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
            'max' => 4096,
          ]),
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
