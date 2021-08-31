<?php

namespace App\Service\Stripe\Api;

use App\Model\Stripe\Amount;
use Stripe\PaymentIntent;

class PaymentIntentsApiClient extends StripeApiClient
{

    public function create(
        Amount $amount,
        string $description = '',
        string $receiptEmail = null
    ): PaymentIntent {
        $baseParams = [
            'amount' => $amount->getAmount(),
            'currency' => $amount->getCurrency(),
            'description' => $description,
            'receipt_email' => $receiptEmail
        ];
        return $this->stripeClient->paymentIntents->create($baseParams);
    }

    public function retrieve(string $paymentIntentId): PaymentIntent
    {
        return $this->stripeClient->paymentIntents->retrieve($paymentIntentId, []);
    }
}
