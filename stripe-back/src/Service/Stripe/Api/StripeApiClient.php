<?php

namespace App\Service\Stripe\Api;

use Stripe\StripeClient;

abstract class StripeApiClient
{

    protected StripeClient $stripeClient;

    public function __construct(string $secretKey)
    {
        $this->stripeClient = new StripeClient($secretKey);
    }
}
