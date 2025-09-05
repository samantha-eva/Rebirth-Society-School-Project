<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends AbstractController
{
    #[Route('/create-payment-intent', name: 'create_payment_intent', methods: ['POST'])]
    public function createPaymentIntent(Request $request): JsonResponse
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Récupérer le panier depuis la session
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // Calculer le montant total
        $amount = 0;
        if (!empty($cart['price'])) {
            foreach ($cart['price'] as $price) {
                $amount += $price; // montant en € ou centimes ?
            }
        }

        // Stripe attend le montant en centimes
        $amountInCents = $amount * 100;

        $paymentIntent = PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return new JsonResponse([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    #[Route('/payment', name: 'payment')]
    public function index(Request $request): Response
    {
        // Récupérer le total du panier pour affichage éventuel
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        $total = 0;
        if (!empty($cart['price'])) {
            $total = array_sum($cart['price']);
        }

        return $this->render('payment/index.html.twig', [
            'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
            'cart_total' => $total
        ]);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(Request $request): Response
    {

        // Récupérer la session
        $session = $request->getSession();

        // Supprimer le panier après paiement réussi
        $session->remove('cart');
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
