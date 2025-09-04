<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends AbstractController
{
    #[Route('/create-payment-intent', name: 'create_payment_intent', methods: ['POST'])]
    public function createPaymentIntent(Request $request): JsonResponse
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Exemple: récupérer le montant depuis la requête ou un produit
        $amount = 2000; // en centimes -> 20.00 EUR

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return new JsonResponse([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
