<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
  #[Route('/product/{id<\d+>}', name: 'app_product_edit', methods: ['GET', 'POST'])]
  public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
  {
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $form->getData()->setUpdatedAt(new \DateTimeImmutable());
      $em->flush();

      $this->addFlash('succès', 'Produit modifié avec succès !');
      return $this->redirectToRoute('app_shop');
    }

    return $this->render('product/edit.html.twig', [
      'product' => $product,
      'form' => $form,
    ]);
  }
}
