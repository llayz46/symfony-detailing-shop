<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\String\u;

class ProductType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $product = $options['data'] ?? null;
    $isEdit = $product && $product->getId();

    $builder
      ->add('name', TextType::class, [
        'label' => 'Nom du produit',
        'attr' => [
          'placeholder' => 'KochChemie - Gentle Snow Foam',
        ],
      ])
      ->add('category', TextType::class, [
        'label' => 'Catégorie',
        'attr' => [
          'placeholder' => 'Shampoing',
        ],
      ])
      ->add('stock', IntegerType::class, [
        'data' => $isEdit ? $product->getStock() : 0,
      ])
      ->add('thumbnailFile', FileType::class, [
        'label' => 'Image du produit',
        'required' => !$isEdit,
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Product::class,
    ]);
  }
}
