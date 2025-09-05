<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PackRepository;
use App\Entity\Pack;
use Symfony\Component\HttpFoundation\Request;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

  #[Route('/cart/{idPack}', name: 'app_add_cart')]
    public function addArticleToCart(string $idPack, Request $request, PackRepository $packRepository): Response
    {
        $session = $request->getSession();

        if (!$session->get('cart')) {
            $session->set('cart', [
                'id' => [],
                'name' => [],
                'price' => [],
                'image' => [],
            ]);
        }

        $cartSession = $session->get('cart');

        $product = $packRepository->find($idPack);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        $cartSession["id"][] = $product->getId();
        $cartSession["name"][] = $product->getName();
        $cartSession["price"][] = $product->getPrice();

        $session->set('cart', $cartSession);

        return $this->render('cart/index.html.twig', [
            'cart_items' => $cartSession,
            'cart_total' => array_sum($cartSession['price']), // total
        ]);
    }


}
