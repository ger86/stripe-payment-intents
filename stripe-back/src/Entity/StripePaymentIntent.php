<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\{Embeddable, Column};

#[Embeddable]

final class StripePaymentIntent
{
    #[Column(name: 'payment_intent_id', type: 'string')]
    private string $paymentIntentId;

    #[Column(name: 'client_secret', type: 'string')]
    private string $clientSecret;

    public function __construct(string $paymentIntentId, string $clientSecret)
    {
        $this->paymentIntentId = $paymentIntentId;
        $this->clientSecret = $clientSecret;
    }

    public function getPaymentIntentId(): string
    {
        return $this->paymentIntentId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
