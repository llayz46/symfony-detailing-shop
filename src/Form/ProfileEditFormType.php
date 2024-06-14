<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileEditFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', TextType::class,)
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
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
