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

class ShopController extends AbstractController
{
  #[Route('/shop', name: 'app_shop')]
  public function browse(ProductRepository $productRepository): Response
  {
    $products = $productRepository->findAll();

    $productsNumber = null;
    foreach ($products as $product) {
      $productsNumber += $product->getStock();
    }

    return $this->render('shop/browse.html.twig', [
      'products' => $products,
      'productsNumber' => $productsNumber,
    ]);
  }

  #[Route('/shop/new', name: 'app_shop_new')]
  public function create(Request $request, EntityManagerInterface $em): Response
  {
    $product = new Product();

    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $category = explode(' ', $form->get('category')->getData());
      foreach ($category as $cat) {
        $cat = strtolower($cat);
        $product->setCategory($cat);
      }

      $em->persist($product);
      $em->flush();

      $this->addFlash('succès', 'Produit ajouté avec succès !');

      return $this->redirectToRoute('app_shop');
    }

    return $this->render('shop/create.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/shop/{id}', name: 'app_shop_show', methods: ['GET'])]
  public function show(Product $product): Response
  {
    return $this->render('shop/show.html.twig', [
      'product' => $product,
    ]);
  }

  #[Route('/shop/{id}', name: 'app_shop_delete', methods: ['DELETE'])]
  public function delete(EntityManagerInterface $em, Product $product, Request $request): Response
  {
    if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->getPayload()->get('_token'))) {
      $em->remove($product);
      $em->flush();

      $this->addFlash('succès', 'Produit supprimé avec succès !');
    }

    return $this->redirectToRoute('app_shop');
  }
}
